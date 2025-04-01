<?php

namespace AppBundle\Soap\EMoscow\Type;

class Comments
{

    /**
     * @var StringType $Comments
     */
    protected $Comments = null;

    /**
     * @param StringType $Comments
     */
    public function __construct($Comments)
    {
      $this->Comments = $Comments;
    }

    /**
     * @return StringType
     */
    public function getComments()
    {
      return $this->Comments;
    }

    /**
     * @param StringType $Comments
     * @return \AppBundle\Soap\EMoscow\Type\Comments
     */
    public function setComments($Comments)
    {
      $this->Comments = $Comments;
      return $this;
    }

}
