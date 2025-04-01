<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RedirectingController extends Controller
{
    public function removeTrailingSlashAction(Request $request)
    {
        $pathInfo = $request->getPathInfo(); // Получаем путь запроса (без домена)
        $requestUri = $request->getRequestUri(); // Полный URI (с параметрами)

        // Удаляем завершающий слеш
        $newPathInfo = rtrim($pathInfo, ' /');
        $url = str_replace($pathInfo, $newPathInfo, $requestUri);

        // Если URL пуст, устанавливаем его как корневой
        if (empty($url)) {
            $url = '/';
        }

        // Проверка на безопасность редиректа
        if (!$this->isSafeUrl($url)) {
            throw new \InvalidArgumentException('Unsafe redirect URL detected.');
        }

        // Выполняем редирект
        return $this->redirect($url, 301);
    }

    /**
     * Проверяет, что URL является безопасным (относительным и внутри текущего сайта).
     */
    private function isSafeUrl($url)
    {
        // Проверяем, что URL начинается с `/` и не является схемозависимым (`//external-site.com`)
        if (!preg_match('#^/#', $url) || preg_match('#^//#', $url)) {
            return false;
        }

        // Дополнительно можно проверить, чтобы URL не содержал опасных символов
        // Например, инъекции с использованием двойных слэшей или некорректных символов
        if (preg_match('#[^\w\-\/\.\?=&]#', $url)) {
            return false;
        }

        return true;
    }

}
