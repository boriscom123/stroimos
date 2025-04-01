<?php

namespace ApiBundle\ApplicationLayer\AbstractCommand;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class SymfonyCommandValidator implements CommandValidatorInterface
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

    public function validate($command)
    {
        $errors = $this->validator->validate($command);
        $validationResult = \count($errors) > 0
            ? new CommandValidationResult($command, $errors)
            : new CommandValidationResult($command);

        return $validationResult;
    }
}
