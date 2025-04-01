<?php

namespace ApiBundle\ApplicationLayer\EmailSubscriptionCommands;

use ApiBundle\ApplicationLayer\AbstractCommand\AbstractSymfonyCommandValidator;

class SaveOptionsCommandValidator extends AbstractSymfonyCommandValidator
{
    /**
     * @return string
     */
    public function getCommandType()
    {
        return SaveOptionsCommandDto::class;
    }
}
