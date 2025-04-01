<?php

namespace ApiBundle\ApplicationLayer\AbstractCommand;

interface CommandHandlerInterface
{
    /**
     * @param string $commandClassName
     * @return bool
     */
    public function supports($commandClassName);

    /**
     * @param $command
     * @param null $transaction
     *
     * @return mixed
     *
     * @throws \ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandValidationException
     */
    public function handle($command, $transaction = null);
}
