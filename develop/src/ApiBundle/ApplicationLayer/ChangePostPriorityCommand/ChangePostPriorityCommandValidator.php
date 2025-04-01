<?php

namespace ApiBundle\ApplicationLayer\ChangePostPriorityCommand;

use ApiBundle\ApplicationLayer\AbstractCommand\AbstractSymfonyCommandValidator;

class ChangePostPriorityCommandValidator extends AbstractSymfonyCommandValidator
{
    /**
     * @return string
     */
    public function getCommandType()
    {
        return ChangePostPriorityCommandDto::class;
    }
}
