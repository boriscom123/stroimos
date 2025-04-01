<?php
namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;

trait MobileRequestListenerTrait
{
    protected function isMobile()
    {
        $appType = getenv('APP_IS_MOBILE');
        if($appType == "10") {
            return true;
        }

        return false;
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function isMobileBundleRequest(Request $request)
    {
        return preg_match('~^((\/app_dev.php)?\/mobile).*$~', $request->getRequestUri());
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    protected function getFullVersionUri(Request $request)
    {
        $uri = $request->getRequestUri();
        $uri = preg_replace('/\/mobile/', '', $uri, 1);

        return $uri === '' ? '/' : $uri;
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function getMobileVersionUri(Request $request)
    {
        $path = preg_replace('~/~', '/mobile/', $request->getPathInfo(), 1);

        return str_replace($request->getPathInfo(), $path, $request->getRequestUri());
    }
}