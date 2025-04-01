<?php
namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    use AuthenticationLoggerAwareTrait;

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $this->authenticationLogger->success($request->getClientIp(), $token->getUser());

        return parent::onAuthenticationSuccess($request, $token);
    }
}
