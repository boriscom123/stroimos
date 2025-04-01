<?php

namespace AppBundle\EventListener;

use AppBundle\Exception\AccessDeniedByOwnerException;
use Stroi\MobileBundle\Exceptions\MobileNotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    use MobileRequestListenerTrait;

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $request = $event->getRequest();
        $exception = $event->getException();
        if($exception instanceof AccessDeniedByOwnerException) {
            $response = new RedirectResponse($request->getBaseUrl() . $request->getPathInfo());
            /** @var Session $session */
            $session = $request->getSession();
            $message = sprintf('Не хватает прав на выполнение действия: "%s"', $exception->getMessage());
            $session->getFlashBag()->add('error', $message);
            $event->setResponse($response);
        }

        if($exception instanceof MobileNotFoundException) {
            if($this->isMobileBundleRequest($request) && !$request->query->get('no_fallback')) {
                $uri = $this->getFullVersionUri($request);
                $request->getSession()->set('full_version_fallback', true);
                $event->setResponse(new RedirectResponse($uri, RedirectResponse::HTTP_FOUND));
            }
        }
    }
}
