<?php

namespace AppBundle\Exception;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AccessDeniedByOwnerException extends AccessDeniedHttpException
{
    /**
     * AccessDeniedByOwnerException constructor.
     * @param string $message
     * @param \Exception|null $previous
     * @param int $code
     */
    public function __construct($message = 'Вы не принадлежите к организации владельцу материала', \Exception $previous = null, $code = 0)
    {
        parent::__construct($message, $previous, $code);
    }
}