<?php

namespace ApiBundle\ApplicationLayer\EmailSubscriptionCommands;

use ApiBundle\ApplicationLayer\AbstractCommand\AbstractSymfonyCommandValidator;

class DeleteSubscriptionCommandValidator extends AbstractSymfonyCommandValidator
{
    /**
     * @return string
     */
    public function getCommandType()
    {
        return DeleteSubscriptionCommandDto::class;
    }
}
