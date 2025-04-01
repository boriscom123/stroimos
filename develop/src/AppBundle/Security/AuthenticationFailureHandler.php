<?php
namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;

class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler
{
    use AuthenticationLoggerAwareTrait;

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $this->authenticationLogger->failure($request->getClientIp(), $exception->getToken()->getUsername(), $exception->getMessage());

        return parent::onAuthenticationFailure($request, $exception);
    }
}
