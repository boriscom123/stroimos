<?php

namespace AppBundle\Soap\EMoscow\Type;

class AttachmentType extends base64Binary
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
     * @var string $href
     */
    protected $href = null;

    /**
     * @var string $contentId
     */
    protected $contentId = null;

    /**
     * @var string $action
     */
    protected $action = null;

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var string $type
     */
    protected $type = null;

    /**
     * @var int $len
     */
    protected $len = null;

    /**
     * @var string $charset
     */
    protected $charset = null;

    /**
     * @var string $attachmentType
     */
    protected $attachmentType = null;

    /**
     * @param base64Binary $_
     * @param anonymous0 $contentType
     * @param base64Binary $_
     * @param anonymous0 $contentType
     * @param string $href
     * @param string $contentId
     * @param string $action
     * @param string $name
     * @param string $type
     * @param int $len
     * @param string $charset
     * @param string $attachmentType
     */
    public function __construct($_, $contentType, $href, $contentId, $action, $name, $type, $len, $charset, $attachmentType)
    {
      parent::__construct($_, $contentType);
      $this->_ = $_;
      $this->contentType = $contentType;
      $this->href = $href;
      $this->contentId = $contentId;
      $this->action = $action;
      $this->name = $name;
      $this->type = $type;
      $this->len = $len;
      $this->charset = $charset;
      $this->attachmentType = $attachmentType;
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
     * @return \AppBundle\Soap\EMoscow\Type\AttachmentType
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
     * @return \AppBundle\Soap\EMoscow\Type\AttachmentType
     */
    public function setContentType($contentType)
    {
      $this->contentType = $contentType;
      return $this;
    }

    /**
     * @return string
     */
    public function getHref()
    {
      return $this->href;
    }

    /**
     * @param string $href
     * @return \AppBundle\Soap\EMoscow\Type\AttachmentType
     */
    public function setHref($href)
    {
      $this->href = $href;
      return $this;
    }

    /**
     * @return string
     */
    public function getContentId()
    {
      return $this->contentId;
    }

    /**
     * @param string $contentId
     * @return \AppBundle\Soap\EMoscow\Type\AttachmentType
     */
    public function setContentId($contentId)
    {
      $this->contentId = $contentId;
      return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
      return $this->action;
    }

    /**
     * @param string $action
     * @return \AppBundle\Soap\EMoscow\Type\AttachmentType
     */
    public function setAction($action)
    {
      $this->action = $action;
      return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->name;
    }

    /**
     * @param string $name
     * @return \AppBundle\Soap\EMoscow\Type\AttachmentType
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
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
     * @return \AppBundle\Soap\EMoscow\Type\AttachmentType
     */
    public function setType($type)
    {
      $this->type = $type;
      return $this;
    }

    /**
     * @return int
     */
    public function getLen()
    {
      return $this->len;
    }

    /**
     * @param int $len
     * @return \AppBundle\Soap\EMoscow\Type\AttachmentType
     */
    public function setLen($len)
    {
      $this->len = $len;
      return $this;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
      return $this->charset;
    }

    /**
     * @param string $charset
     * @return \AppBundle\Soap\EMoscow\Type\AttachmentType
     */
    public function setCharset($charset)
    {
      $this->charset = $charset;
      return $this;
    }

    /**
     * @return string
     */
    public function getAttachmentType()
    {
      return $this->attachmentType;
    }

    /**
     * @param string $attachmentType
     * @return \AppBundle\Soap\EMoscow\Type\AttachmentType
     */
    public function setAttachmentType($attachmentType)
    {
      $this->attachmentType = $attachmentType;
      return $this;
    }

}
