<?php

namespace AppBundle\Soap\EMoscow\Type;

class Resolution
{

    /**
     * @var StringType $Resolution
     */
    protected $Resolution = null;

    /**
     * @param StringType $Resolution
     */
    public function __construct($Resolution)
    {
      $this->Resolution = $Resolution;
    }

    /**
     * @return StringType
     */
    public function getResolution()
    {
      return $this->Resolution;
    }

    /**
     * @param StringType $Resolution
     * @return \AppBundle\Soap\EMoscow\Type\Resolution
     */
    public function setResolution($Resolution)
    {
      $this->Resolution = $Resolution;
      return $this;
    }

}
