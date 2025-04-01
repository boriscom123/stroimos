<?php

namespace ApiBundle\ApplicationLayer\AbstractCommand;

class CommandValidationResult
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var object
     */
    private $command;

    /**
     * CommandValidationResult constructor.
     * @param object $command
     * @param \ArrayAccess|null $errors
     */
    public function __construct($command, \ArrayAccess $errors = null)
    {
        $this->command = $command;
        $this->errors = $errors;
    }

    /**
     * @param string $fieldName
     * @param string $message
     */
    public function addError($fieldName, $message)
    {
        if (!isset($this->errors[$fieldName])) {
            $this->errors[$fieldName] = [];
        }
        $this->errors[$fieldName][] = $message;
    }

    /**
     * @return array|\ArrayAccess
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * @return object
     */
    public function getCommand()
    {
        return $this->command;
    }
}
