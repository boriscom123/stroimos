<?php

namespace AppBundle\Soap\EMoscow\Type;

class HPSMInteractionsFromMosRuModelType
{

    /**
     * @var HPSMInteractionsFromMosRuKeysType $keys
     */
    protected $keys = null;

    /**
     * @var HPSMInteractionsFromMosRuInstanceType $instance
     */
    protected $instance = null;

    /**
     * @var MessagesType $messages
     */
    protected $messages = null;

    /**
     * @var string $query
     */
    protected $query = null;

    /**
     * @param HPSMInteractionsFromMosRuKeysType $keys
     * @param HPSMInteractionsFromMosRuInstanceType $instance
     * @param MessagesType $messages
     * @param string $query
     */
    public function __construct($keys, $instance, $messages, $query)
    {
      $this->keys = $keys;
      $this->instance = $instance;
      $this->messages = $messages;
      $this->query = $query;
    }

    /**
     * @return HPSMInteractionsFromMosRuKeysType
     */
    public function getKeys()
    {
      return $this->keys;
    }

    /**
     * @param HPSMInteractionsFromMosRuKeysType $keys
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuModelType
     */
    public function setKeys($keys)
    {
      $this->keys = $keys;
      return $this;
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
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuModelType
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
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuModelType
     */
    public function setMessages($messages)
    {
      $this->messages = $messages;
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
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuModelType
     */
    public function setQuery($query)
    {
      $this->query = $query;
      return $this;
    }

}
