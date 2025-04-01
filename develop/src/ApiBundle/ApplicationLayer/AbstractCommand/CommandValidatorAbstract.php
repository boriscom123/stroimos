<?php

namespace ApiBundle\ApplicationLayer\AbstractCommand;

use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandTypeException;

abstract class CommandValidatorAbstract implements CommandValidatorInterface
{
    abstract public function getCommandType();

    /**
     * @param $command
     *
     * @return CommandValidationResult
     *
     * @throws CommandTypeException
     */
    public function validate($command)
    {
        $commandType = $this->getCommandType();
        if (!($command instanceof $commandType)) {
            throw new CommandTypeException('');
        }

        return $this->validateCommandProps($command);
    }

    abstract protected function validateCommandProps($command);
}
