<?php

namespace ApiBundle\ApplicationLayer\AbstractCommand\Exception;

use ApiBundle\ApplicationLayer\AbstractCommand\CommandValidationResult;

class CommandValidationException extends CommandException
{
    /**
     * @var \ApiBundle\ApplicationLayer\AbstractCommand\CommandValidationResult
     */
    private $validationResult;

    /**
     * @param CommandValidationResult $validationResult
     */
    public function __construct(CommandValidationResult $validationResult)
    {
        parent::__construct('Command args is not valid');
        $this->validationResult = $validationResult;
    }

    /**
     * @return CommandValidationResult
     */
    public function getValidationResult()
    {
        return $this->validationResult;
    }
}
