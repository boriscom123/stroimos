<?php

namespace AppBundle\Soap\EMoscow\Type;

class Description
{

    /**
     * @var StringType $Description
     */
    protected $Description = null;

    /**
     * @param StringType $Description
     */
    public function __construct($Description)
    {
      $this->Description = $Description;
    }

    /**
     * @return StringType
     */
    public function getDescription()
    {
      return $this->Description;
    }

    /**
     * @param StringType $Description
     * @return \AppBundle\Soap\EMoscow\Type\Description
     */
    public function setDescription($Description)
    {
      $this->Description = $Description;
      return $this;
    }

}
