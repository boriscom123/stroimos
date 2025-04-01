<?php

namespace AppBundle\Soap\EMoscow\Type;

class Feedback
{

    /**
     * @var StringType $Feedback
     */
    protected $Feedback = null;

    /**
     * @param StringType $Feedback
     */
    public function __construct($Feedback)
    {
      $this->Feedback = $Feedback;
    }

    /**
     * @return StringType
     */
    public function getFeedback()
    {
      return $this->Feedback;
    }

    /**
     * @param StringType $Feedback
     * @return \AppBundle\Soap\EMoscow\Type\Feedback
     */
    public function setFeedback($Feedback)
    {
      $this->Feedback = $Feedback;
      return $this;
    }

}
