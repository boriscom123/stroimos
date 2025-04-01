<?php

namespace AppBundle\Soap\EMoscow\Type;

class RetrieveHPSMInteractionsFromMosRuListResponse
{

    /**
     * @var HPSMInteractionsFromMosRuInstanceType $instance
     */
    protected $instance = null;

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
     * @var string $handle
     */
    protected $handle = null;

    /**
     * @var int $count
     */
    protected $count = null;

    /**
     * @var boolean $more
     */
    protected $more = null;

    /**
     * @var int $start
     */
    protected $start = null;

    /**
     * @param HPSMInteractionsFromMosRuInstanceType $instance
     * @param MessagesType $messages
     * @param StatusType $status
     * @param string $message
     * @param date $schemaRevisionDate
     * @param int $schemaRevisionLevel
     * @param float $returnCode
     * @param string $query
     * @param string $handle
     * @param int $count
     * @param boolean $more
     * @param int $start
     */
    public function __construct($instance, $messages, $status, $message, $schemaRevisionDate, $schemaRevisionLevel, $returnCode, $query, $handle, $count, $more, $start)
    {
      $this->instance = $instance;
      $this->messages = $messages;
      $this->status = $status;
      $this->message = $message;
      $this->schemaRevisionDate = $schemaRevisionDate;
      $this->schemaRevisionLevel = $schemaRevisionLevel;
      $this->returnCode = $returnCode;
      $this->query = $query;
      $this->handle = $handle;
      $this->count = $count;
      $this->more = $more;
      $this->start = $start;
    }

    /**
     * @return HPSMInteractionsFromMosRuInstanceType
     */
    public function getInstance()
    {
      return $this->instance;
    }

    /**
     * @param HPSMInteractionsFromMosRuInstanceType $instance
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
     */
    public function setInstance($instance)
    {
      $this->instance = $instance;
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
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
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
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
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
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
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
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
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
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
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
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
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
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
     */
    public function setQuery($query)
    {
      $this->query = $query;
      return $this;
    }

    /**
     * @return string
     */
    public function getHandle()
    {
      return $this->handle;
    }

    /**
     * @param string $handle
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
     */
    public function setHandle($handle)
    {
      $this->handle = $handle;
      return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
      return $this->count;
    }

    /**
     * @param int $count
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
     */
    public function setCount($count)
    {
      $this->count = $count;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getMore()
    {
      return $this->more;
    }

    /**
     * @param boolean $more
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
     */
    public function setMore($more)
    {
      $this->more = $more;
      return $this;
    }

    /**
     * @return int
     */
    public function getStart()
    {
      return $this->start;
    }

    /**
     * @param int $start
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuListResponse
     */
    public function setStart($start)
    {
      $this->start = $start;
      return $this;
    }

}
