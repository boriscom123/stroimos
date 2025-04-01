<?php

namespace AppBundle\Soap\EMoscow\Type;

class AttachmentsType
{

    /**
     * @var AttachmentType[] $attachment
     */
    protected $attachment = null;

    /**
     * @param AttachmentType[] $attachment
     */
    public function __construct(array $attachment)
    {
      $this->attachment = $attachment;
    }

    /**
     * @return AttachmentType[]
     */
    public function getAttachment()
    {
      return $this->attachment;
    }

    /**
     * @param AttachmentType[] $attachment
     * @return \AppBundle\Soap\EMoscow\Type\AttachmentsType
     */
    public function setAttachment(array $attachment)
    {
      $this->attachment = $attachment;
      return $this;
    }

}
