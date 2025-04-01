<?php

namespace ApiBundle\ApplicationLayer\AbstractCommand\Exception;

use Throwable;

class CommandExecutionException extends CommandException
{
    const NOT_FOUND = 404;
    /**
     * @var null
     */
    private $intermediateResult;

    public function __construct($message = '', $code = 0, Throwable $previous = null, $intermediateResult = null)
    {
        parent::__construct($message, $code, $previous);

        $this->intermediateResult = $intermediateResult;
    }

    public function getIntermediateResult()
    {
        return $this->intermediateResult;
    }
}
