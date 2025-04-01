<?php

namespace AppBundle\Soap\EMoscow\Type;

class CreateHPSMInteractionsFromMosRuResponse
{

    /**
     * @var HPSMInteractionsFromMosRuModelType $model
     */
    protected $model = null;

    /**
     * @var MessagesType $messages
     */
    protected $messages = null;

    /**
     * @var StatusType $status
     */
    protected $status = null;

    /**
     * @var string $message
     */
    protected $message = null;

    /**
     * @var date $schemaRevisionDate
     */
    protected $schemaRevisionDate = null;

    /**
     * @var int $schemaRevisionLevel
     */
    protected $schemaRevisionLevel = null;

    /**
     * @var float $returnCode
     */
    protected $returnCode = null;

    /**
     * @var string $query
     */
    protected $query = null;

    /**
     * @param HPSMInteractionsFromMosRuModelType $model
     * @param MessagesType $messages
     * @param StatusType $status
     * @param string $message
     * @param date $schemaRevisionDate
     * @param int $schemaRevisionLevel
     * @param float $returnCode
     * @param string $query
     */
    public function __construct($model, $messages, $status, $message, $schemaRevisionDate, $schemaRevisionLevel, $returnCode, $query)
    {
      $this->model = $model;
      $this->messages = $messages;
      $this->status = $status;
      $this->message = $message;
      $this->schemaRevisionDate = $schemaRevisionDate;
      $this->schemaRevisionLevel = $schemaRevisionLevel;
      $this->returnCode = $returnCode;
      $this->query = $query;
    }

    /**
     * @return HPSMInteractionsFromMosRuModelType
     */
    public function getModel()
    {
      return $this->model;
    }

    /**
     * @param HPSMInteractionsFromMosRuModelType $model
     * @return \AppBundle\Soap\EMoscow\Type\CreateHPSMInteractionsFromMosRuResponse
     */
    public function setModel($model)
    {
      $this->model = $model;
      return $this;
    }

    /**
     * @return MessagesType
     */
    public function getMessages()
    {
      return $this->messages;
    }

    /**
     * @param MessagesType $messages
     * @return \AppBundle\Soap\EMoscow\Type\CreateHPSMInteractionsFromMosRuResponse
     */
    public function setMessages($messages)
    {
      $this->messages = $messages;
      return $this;
    }

    /**
     * @return StatusType
     */
    public function getStatus()
    {
      return $this->status;
    }

    /**
     * @param StatusType $status
     * @return \AppBundle\Soap\EMoscow\Type\CreateHPSMInteractionsFromMosRuResponse
     */
    public function setStatus($status)
    {
      $this->status = $status;
      return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
      return $this->message;
    }

    /**
     * @param string $message
     * @return \AppBundle\Soap\EMoscow\Type\CreateHPSMInteractionsFromMosRuResponse
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

    /**
     * @return date
     */
    public function getSchemaRevisionDate()
    {
      return $this->schemaRevisionDate;
    }

    /**
     * @param date $schemaRevisionDate
     * @return \AppBundle\Soap\EMoscow\Type\CreateHPSMInteractionsFromMosRuResponse
     */
    public function setSchemaRevisionDate($schemaRevisionDate)
    {
      $this->schemaRevisionDate = $schemaRevisionDate;
      return $this;
    }

    /**
     * @return int
     */
    public function getSchemaRevisionLevel()
    {
      return $this->schemaRevisionLevel;
    }

    /**
     * @param int $schemaRevisionLevel
     * @return \AppBundle\Soap\EMoscow\Type\CreateHPSMInteractionsFromMosRuResponse
     */
    public function setSchemaRevisionLevel($schemaRevisionLevel)
    {
      $this->schemaRevisionLevel = $schemaRevisionLevel;
      return $this;
    }

    /**
     * @return float
     */
    public function getReturnCode()
    {
      return $this->returnCode;
    }

    /**
     * @param float $returnCode
     * @return \AppBundle\Soap\EMoscow\Type\CreateHPSMInteractionsFromMosRuResponse
     */
    public function setReturnCode($returnCode)
    {
      $this->returnCode = $returnCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
      return $this->query;
    }

    /**
     * @param string $query
     * @return \AppBundle\Soap\EMoscow\Type\CreateHPSMInteractionsFromMosRuResponse
     */
    public function setQuery($query)
    {
      $this->query = $query;
      return $this;
    }

}
