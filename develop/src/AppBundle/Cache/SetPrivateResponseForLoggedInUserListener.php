<?php

namespace AppBundle\Cache;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class SetPrivateResponseForLoggedInUserListener
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $token = $this->tokenStorage->getToken();

        if (!$token instanceof  TokenInterface) {
            return;
        }

        if (!is_object($token->getUser())) {
            return;
        }

        $event->getResponse()->setPrivate(true);
    }
}
