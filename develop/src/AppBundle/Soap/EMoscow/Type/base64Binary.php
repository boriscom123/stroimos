<?php

namespace AppBundle\Soap\EMoscow\Type;

class base64Binary
{

    /**
     * @var base64Binary $_
     */
    protected $_ = null;

    /**
     * @var anonymous0 $contentType
     */
    protected $contentType = null;

    /**
     * @param base64Binary $_
     * @param anonymous0 $contentType
     */
    public function __construct($_, $contentType)
    {
      $this->_ = $_;
      $this->contentType = $contentType;
    }

    /**
     * @return base64Binary
     */
    public function get_()
    {
      return $this->_;
    }

    /**
     * @param base64Binary $_
     * @return \AppBundle\Soap\EMoscow\Type\base64Binary
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
     * @return \AppBundle\Soap\EMoscow\Type\base64Binary
     */
    public function setContentType($contentType)
    {
      $this->contentType = $contentType;
      return $this;
    }

}
