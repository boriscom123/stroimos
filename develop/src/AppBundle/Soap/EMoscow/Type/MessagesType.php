<?php

namespace AppBundle\Soap\EMoscow\Type;

class MessagesType
{

    /**
     * @var MessageType[] $message
     */
    protected $message = null;

    /**
     * @param MessageType[] $message
     */
    public function __construct(array $message)
    {
      $this->message = $message;
    }

    /**
     * @return MessageType[]
     */
    public function getMessage()
    {
      return $this->message;
    }

    /**
     * @param MessageType[] $message
     * @return \AppBundle\Soap\EMoscow\Type\MessagesType
     */
    public function setMessage(array $message)
    {
      $this->message = $message;
      return $this;
    }

}
