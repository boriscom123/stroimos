<?php
namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Logout\DefaultLogoutSuccessHandler;

class LogoutSuccessHandler extends DefaultLogoutSuccessHandler
{
    use AuthenticationLoggerAwareTrait;

    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    public function setSecurityContext(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function onLogoutSuccess(Request $request)
    {
//        $this->authenticationLogger->logout($request->getClientIp(), $this->securityContext->getToken()->getUser());

        return parent::onLogoutSuccess($request);
    }
}