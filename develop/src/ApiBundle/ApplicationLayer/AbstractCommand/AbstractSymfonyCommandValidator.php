<?php

namespace ApiBundle\ApplicationLayer\AbstractCommand;

use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractSymfonyCommandValidator extends CommandValidatorAbstract
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        ValidatorInterface $validator
    ) {
        $this->validator = $validator;
    }

    /**
     * @param  $command
     *
     * @return CommandValidationResult
     */
    public function validateCommandProps($command)
    {
        $errors = $this->validator->validate($command);
        $validationResult = \count($errors) > 0
            ? new CommandValidationResult($command, $errors)
            : new CommandValidationResult($command);

        return $validationResult;
    }
}
