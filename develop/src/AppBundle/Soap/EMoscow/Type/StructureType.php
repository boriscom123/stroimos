<?php

namespace AppBundle\Soap\EMoscow\Type;

class StructureType
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
     * @return \AppBundle\Soap\EMoscow\Type\StructureType
     */
    public function setType($type)
    {
      $this->type = $type;
      return $this;
    }

}
