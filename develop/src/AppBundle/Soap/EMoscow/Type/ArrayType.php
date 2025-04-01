<?php

namespace AppBundle\Soap\EMoscow\Type;

class ArrayType
{

    /**
     * @var string $type
     */
    protected $type = null;

    /**
     * @param string $type
     */
    public function __construct($type)
    {
      $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
      return $this->type;
    }

    /**
     * @param string $type
     * @return \AppBundle\Soap\EMoscow\Type\ArrayType
     */
    public function setType($type)
    {
      $this->type = $type;
      return $this;
    }

}
