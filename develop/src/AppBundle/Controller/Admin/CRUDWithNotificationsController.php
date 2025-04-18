<?php

namespace AppBundle\Controller\Admin;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use AppBundle\Admin\AdminWithNotifications;
use AppBundle\Rest\SendSayClient;
use AppBundle\Entity\Notification;
use Monolog\Logger;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\SessionStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CRUDWithNotificationsController extends BaseAdminController
{
    public function deleteAction($id)
    {
        if(!$this->admin instanceof AdminWithNotifications) {
            throw new \Exception('Неправильная конфигурация');
        }

        if($this->admin->getNotificationsCount($id) > 0) {
            $this->addFlash(
                'sonata_flash_error',
                'Невозможно удалить публикацию, так как о ней было отправлено уведомление'
            );

            return new RedirectResponse(
                $this->admin->generateUrl(
                    'list',
                    array('filter' => $this->admin->getFilterParameters())
                )
            );
        }

        return parent::deleteAction($id); // TODO: Change the autogenerated stub
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendNotificationAction(Request $request)
    {
        /** @var FlashBagInterface $flashBag */
        $flashBag = $request->getSession()->getBag('flashes');
        try {
            /** @var IdentifiableInterface $subject */
            $subject = $this->admin->getSubject();
            $res = $this->processNotification($request, $subject);
            //add notification counter
            $manager = $this->getDoctrine()->getManager();
            $notification = new Notification();
            $notification->setModule($this->admin->getLabel());
            $notification->setEntityId($subject->getId());
            $notification->setUsername($this->getUser());
            $manager->persist($notification);
            $manager->flush();
            $flashBag->add('sonata_flash_success', 'Уведомление отправлено');
        } catch (\Exception $e) {
            $flashBag->add('sonata_flash_error', $e->getMessage());
        }

        return new RedirectResponse(
            $this->admin->generateUrl(
                'list',
                array('filter' => $this->admin->getFilterParameters())
            )
        );
    }

    /**
     * @param Request $request
     * @param IdentifiableInterface $subject
     * @return mixed
     * @throws \Exception
     */
    private function processNotification(Request $request, $subject)
    {
        if(!$this->admin instanceof AdminWithNotifications) {
            throw new \Exception('Неправильная конфигурация');
        }

        if(!$this->admin->getNotificationsAllowed($subject)) {
            throw new \Exception('Невозможно отправить уведомление');
        }

        $result = $this->sendNotificationForPush($request);
        if(isset($result['errors'])) {
            /** @var Logger $logger */
            $logger = $this->getLogger();
            $logger->error($result);
            throw new \Exception('Ошибка при отправке уведомления ' . $result );
        }

        return $result;
    }

    /**
     * @param Request $request
     * @return mixed|null
     */
    private function sendNotificationForPush(Request $request)
    {
        /** @var EntitledInterface $subject */
        $subject = $this->admin->getSubject();
        $urlGenerator = $this->container->get('app.entity_url_generator');

        $spApiclient = new SendSayClient(
            $this->container->getParameter('sendsay_account'),
            $this->container->getParameter('sendsay_key'),
            $this->container->getParameter('sendsay_group')
        );

        $data = [
            'subject' => 'Градостроительный комплекс Москвы',
            'message' => $subject->getTitle(),
            'url' => $urlGenerator->generate($subject, ['from' => 'push'], UrlGeneratorInterface::ABSOLUTE_URL),
        ];

        return $spApiclient->issueSend($data);
    }
}
