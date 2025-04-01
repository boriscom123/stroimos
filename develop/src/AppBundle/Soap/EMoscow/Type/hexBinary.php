<?php

namespace AppBundle\Soap\EMoscow\Type;

class hexBinary
{

    /**
     * @var string $_
     */
    protected $_ = null;

    /**
     * @var anonymous0 $contentType
     */
    protected $contentType = null;

    /**
     * @param string $_
     * @param anonymous0 $contentType
     */
    public function __construct($_, $contentType)
    {
      $this->_ = $_;
      $this->contentType = $contentType;
    }

    /**
     * @return string
     */
    public function get_()
    {
      return $this->_;
    }

    /**
     * @param string $_
     * @return \AppBundle\Soap\EMoscow\Type\hexBinary
     */
    public function set_($_)
    {
      $this->_ = $_;
      return $this;
    }

    /**
     * @return anonymous0
     */
    public function getContentType()
    {
      return $this->contentType;
    }

    /**
     * @param anonymous0 $contentType
     * @return \AppBundle\Soap\EMoscow\Type\hexBinary
     */
    public function setContentType($contentType)
    {
      $this->contentType = $contentType;
      return $this;
    }

}
