<?php
    namespace AppBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use AppBundle\Entity\Appeal;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class AppealController extends Controller
    {
        /**
         * @Route("/appeal/submit", name="app_appeal_submit", methods={"POST"})
         */
        public function submitAction(Request $request)
        {
            if (!$this->isCsrfTokenValid('appeal', $request->request->get('_csrf_token'))) {
                return new Response('Ошибка CSRF токена.', Response::HTTP_FORBIDDEN);
            }

            if ($request->isMethod('POST')) {
                $data = $request->request->all();
                $errors = [];

                // Валидация данных
                if (empty($data['name'])) {
                    $errors['name'] = 'Поле "Имя" обязательно для заполнения.';
                }
                if (empty($data['surname'])) {
                    $errors['surname'] = 'Поле "Фамилия" обязательно для заполнения.';
                }
                if (empty($data['phone']) || !preg_match('/^\+7\d{10}$/', $data['phone'])) {
                    $errors['phone'] = 'Введите корректный телефон в формате +7XXXXXXXXXX.';
                }
                if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Введите корректный адрес электронной почты.';
                }
                if (empty($data['message'])) {
                    $errors['message'] = 'Поле "Сообщение" обязательно для заполнения.';
                }

                if (!empty($errors)) {
                    return new JsonResponse(['status' => 'error', 'errors' => $errors], 400);
                }

                // Собираем данные
                $personLegal = $request->request->get('person-legal', 'person');
                $legalEntity = $request->request->get('legal-entity', null);

                $appeal = new Appeal();
                $appeal->setName($request->request->get('name'));
                $appeal->setSurname($request->request->get('surname'));
                $appeal->setPhone($request->request->get('phone'));
                $appeal->setEmail($request->request->get('email'));
                $appeal->setPersonType($personLegal);
                $appeal->setOrganization($legalEntity);
                $appeal->setMessage($request->request->get('message'));
                $appeal->setApiStatus('pending'); // Устанавливаем статус "pending" (ожидает отправки)

                // Сохранение в базу
                $em = $this->getDoctrine()->getManager();
                $em->persist($appeal);
                $em->flush();

                // Логируем успешное сохранение
                $this->get('logger')->info('Данные формы успешно сохранены в БД', [
                    'id' => $appeal->getId(),
                    'data' => $data,
                ]);

                // Запускаем отправку в API асинхронно
                try {
                    $this->sendToApiAsync($appeal, $personLegal, $legalEntity);
                } catch (\Exception $e) {
                    $this->get('logger')->error('Ошибка при запуске отправки данных в API: ' . $e->getMessage());
                }

                // Независимо от результата отправки, возвращаем успех для фронта
                return new JsonResponse(['status' => 'success', 'message' => 'Форма успешно сохранена!']);
            }

            return new JsonResponse(['status' => 'error', 'message' => 'Неверный метод запроса.'], 405);
        }


        private function sendToApiAsync(Appeal $appeal, $personLegal, $legalEntity)
        {
            $em = $this->getDoctrine()->getManager();

            try {
                $response = $this->sendXmlToApi($appeal, $personLegal, $legalEntity);

                if ($response['response'] === 'done') {
                    $appeal->setApiStatus('done'); // Успешная отправка
                } else {
                    $this->get('logger')->error('Ошибка отправки в API: ' . $response['response']);
                    $appeal->setApiStatus('failed'); // Ошибка отправки
                }
            } catch (\Exception $e) {
                $this->get('logger')->error('Ошибка отправки в API: ' . $e->getMessage());
                $appeal->setApiStatus('failed'); // Ошибка при отправке
            }

            // Обновляем статус в БД
            $em->persist($appeal);
            $em->flush();
        }


        private function generateXml(Appeal $appeal)
        {
            // Создаем объект SimpleXMLElement
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><APPEAL xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></APPEAL>');

            // Заполняем XML данными
            $xml->addChild('APPEAL_DATE', (new \DateTime())->format('Y-m-d\TH:i:s.uP'));
            $xml->addChild('FIRST_NAME', $appeal->getName());
            $xml->addChild('LAST_NAME', $appeal->getSurname());
            $xml->addChild('PHONE', $appeal->getPhone());
            $xml->addChild('EMAIL', $appeal->getEmail());
            $xml->addChild('APPLICANT_TYPE_NICK', $appeal->getPersonType());
            $xml->addChild('APPEAL_TEXT', $appeal->getMessage());
            $xml->addChild('APPLICANT_ORG', $appeal->getOrganization() ?: '');
            $xml->addChild('APPLICANT_ORG_INN', ''); // Пока пустое значение
            $xml->addChild('APPLICANT_ORG_OGRN', ''); // Пока пустое значение
            $xml->addChild('APPEAL_TYPE_NICK', '');
            $xml->addChild('LABELS', '');
            $xml->addChild('COMPLAIN_ORG', '');
            $xml->addChild('POSITION', '');
            $xml->addChild('COMPLAIN_PERIOD_SINCE', '');
            $xml->addChild('COMPLAIN_PERIOD_TO', '');
            $xml->addChild('OBJECTS', '');

            // Добавляем вложенный элемент ADDRESS
            $address = $xml->addChild('ADDRESS');
            $address->addChild('ADDRESS_STR', '');
            $address->addChild('DIST_PREF_ID', '');
            $address->addChild('ADD_INFO', '');
            $address->addChild('LAUNCH_YEAR', '')->addAttribute('xsi:nil', 'true', 'http://www.w3.org/2001/XMLSchema-instance');

            // Добавляем оставшиеся элементы
            $xml->addChild('APPEAL_ANSWER', '')->addAttribute('xsi:nil', 'true', 'http://www.w3.org/2001/XMLSchema-instance');
            $xml->addChild('APPEAL_COMMENT', '')->addAttribute('xsi:nil', 'true', 'http://www.w3.org/2001/XMLSchema-instance');
            $xml->addChild('FILES', '');

            $feedback = $xml->addChild('FEEDBACK');
            $feedback->addChild('RENOV', '')->addAttribute('xsi:nil', 'true', 'http://www.w3.org/2001/XMLSchema-instance');

            // Возвращаем XML как строку
            return $xml->asXML();
        }

        private function sendXmlToApi(Appeal $appeal)
        {
            // Генерация XML
            $xmlContent = $this->generateXml($appeal);

            // URL-encoded XML
            $encodedXml = urlencode($xmlContent);

            // Формирование URL
            $url = 'https://ugd.mos.ru/putXmlHotline/sendMessage?xml=' . $encodedXml . '&num=10';

            // Инициализация curl
            $ch = curl_init();

            // Настройка curl
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);
            curl_setopt($ch, CURLOPT_POST, 1);

            // Выполнение запроса
            $response = curl_exec($ch);

            // Обработка ошибок
            if (curl_errno($ch)) {
                error_log('Ошибка отправки данных по API: ' . curl_error($ch));
                $result = ['success' => false, 'response' => $response];
            } else {
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($httpCode !== 200) {
                    error_log('Ошибка API: HTTP код ' . $httpCode . ' Ответ: ' . $response);
                    $result = ['success' => false, 'response' => $response];
                } else {
                    error_log('Успешный ответ от API: ' . $response);
                    $result = ['success' => true, 'response' => $response];
                }
            }

            // Закрытие curl
            curl_close($ch);
            return $result;
        }

        /**
         * @Route("/admin/app/appeal/{id}/retry-send", name="app_admin_appeal_retry_send")
         */
        public function retrySendAction(Request $request, $id)
        {
            $em = $this->getDoctrine()->getManager();
            $appeal = $em->getRepository('AppBundle:Appeal')->find($id);

            if (!$appeal) {
                throw $this->createNotFoundException('Запись не найдена.');
            }

            try {
                // Логика переотправки данных в API
                $response = $this->sendXmlToApi($appeal);

                if ($response['response'] === 'done') {
                    $appeal->setApiStatus('done');
                } else {
                    $this->get('logger')->error('Ошибка отправки в API: ' . $response['response']);
                    $appeal->setApiStatus('failed');
                }
            } catch (\Exception $e) {
                $appeal->setApiStatus('failed');
            }

            $em->persist($appeal);
            $em->flush();

            $this->addFlash('sonata_flash_success', sprintf('Переотправка для записи #%d завершена.', $id));

            return $this->redirectToRoute('admin_app_appeal_list');
        }


    }
