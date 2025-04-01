<?php

namespace ApiBundle\ApplicationLayer\AbstractCommand;

use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandValidationException;
use ApiBundle\ApplicationLayer\AbstractCommand\Exception\UnsupportedCommandException;

abstract class CommandHandlerAbstract implements CommandHandlerInterface
{
    /**
     * @var \ApiBundle\ApplicationLayer\AbstractCommand\CommandValidatorAbstract
     */
    private $validator;
    /**
     * @var string null
     */
    private $commandClassName;

    public function __construct(
        CommandValidatorInterface $validator = null,
        $commandClassName = null
    ) {
        $this->validator = $validator;
        $this->commandClassName = $commandClassName;
    }

    public function supports($command)
    {

        return $this->commandClassName
            ? $command instanceof $this->commandClassName
            : true;
    }

    /**
     * @return CommandValidatorInterface|null
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param object $command
     * @param null   $transaction
     *
     * @return mixed
     *
     * @throws CommandValidationException
     * @throws Exception\CommandExecutionException
     * @throws Exception\CommandTypeException
     */
    public function handle($command, $transaction = null)
    {
        if (!$this->supports($command)) {
            $handlerClassName = static::class;
            $commandClassName = get_class($command);
            throw new UnsupportedCommandException("Command type $commandClassName is unsupported by handler $handlerClassName");
        }
        $this->validate($command);

        return $this->execute($command);
    }

    /**
     * @return bool
     */
    public function hasValidator()
    {
        return (bool) $this->validator;
    }

    /**
     * @param object $command
     *
     * @throws CommandValidationException
     * @throws Exception\CommandTypeException
     */
    protected function validate($command)
    {
        if (null === $this->validator) {
            return;
        }

        $validationResult = $this->validator->validate($command);
        if ($validationResult->hasErrors()) {
            throw new CommandValidationException($validationResult);
        }
    }

    /**
     * @param $command
     *
     * @return mixed
     *
     * @throws \ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandExecutionException
     */
    abstract protected function execute($command);
}
