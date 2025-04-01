<?php
namespace AppBundle\Security;

trait AuthenticationLoggerAwareTrait
{
    /**
     * @var AuthenticationLogger
     */
    protected $authenticationLogger;

    public function setAuthenticationLogger(AuthenticationLogger $authenticationLogger)
    {
        $this->authenticationLogger = $authenticationLogger;
    }
}