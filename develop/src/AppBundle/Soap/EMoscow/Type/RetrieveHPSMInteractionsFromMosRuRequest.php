<?php

namespace AppBundle\Soap\EMoscow\Type;

class RetrieveHPSMInteractionsFromMosRuRequest
{

    /**
     * @var HPSMInteractionsFromMosRuModelType $model
     */
    protected $model = null;

    /**
     * @var boolean $attachmentInfo
     */
    protected $attachmentInfo = null;

    /**
     * @var boolean $attachmentData
     */
    protected $attachmentData = null;

    /**
     * @var boolean $ignoreEmptyElements
     */
    protected $ignoreEmptyElements = null;

    /**
     * @var boolean $updatecounter
     */
    protected $updatecounter = null;

    /**
     * @var string $handle
     */
    protected $handle = null;

    /**
     * @var int $count
     */
    protected $count = null;

    /**
     * @var int $start
     */
    protected $start = null;

    /**
     * @param HPSMInteractionsFromMosRuModelType $model
     * @param boolean $attachmentInfo
     * @param boolean $attachmentData
     * @param boolean $ignoreEmptyElements
     * @param boolean $updatecounter
     * @param string $handle
     * @param int $count
     * @param int $start
     */
    public function __construct($model, $attachmentInfo, $attachmentData, $ignoreEmptyElements, $updatecounter, $handle, $count, $start)
    {
      $this->model = $model;
      $this->attachmentInfo = $attachmentInfo;
      $this->attachmentData = $attachmentData;
      $this->ignoreEmptyElements = $ignoreEmptyElements;
      $this->updatecounter = $updatecounter;
      $this->handle = $handle;
      $this->count = $count;
      $this->start = $start;
    }

    /**
     * @return HPSMInteractionsFromMosRuModelType
     */
    public function getModel()
    {
      return $this->model;
    }

    /**
     * @param HPSMInteractionsFromMosRuModelType $model
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuRequest
     */
    public function setModel($model)
    {
      $this->model = $model;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getAttachmentInfo()
    {
      return $this->attachmentInfo;
    }

    /**
     * @param boolean $attachmentInfo
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuRequest
     */
    public function setAttachmentInfo($attachmentInfo)
    {
      $this->attachmentInfo = $attachmentInfo;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getAttachmentData()
    {
      return $this->attachmentData;
    }

    /**
     * @param boolean $attachmentData
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuRequest
     */
    public function setAttachmentData($attachmentData)
    {
      $this->attachmentData = $attachmentData;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getIgnoreEmptyElements()
    {
      return $this->ignoreEmptyElements;
    }

    /**
     * @param boolean $ignoreEmptyElements
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuRequest
     */
    public function setIgnoreEmptyElements($ignoreEmptyElements)
    {
      $this->ignoreEmptyElements = $ignoreEmptyElements;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getUpdatecounter()
    {
      return $this->updatecounter;
    }

    /**
     * @param boolean $updatecounter
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuRequest
     */
    public function setUpdatecounter($updatecounter)
    {
      $this->updatecounter = $updatecounter;
      return $this;
    }

    /**
     * @return string
     */
    public function getHandle()
    {
      return $this->handle;
    }

    /**
     * @param string $handle
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuRequest
     */
    public function setHandle($handle)
    {
      $this->handle = $handle;
      return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
      return $this->count;
    }

    /**
     * @param int $count
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuRequest
     */
    public function setCount($count)
    {
      $this->count = $count;
      return $this;
    }

    /**
     * @return int
     */
    public function getStart()
    {
      return $this->start;
    }

    /**
     * @param int $start
     * @return \AppBundle\Soap\EMoscow\Type\RetrieveHPSMInteractionsFromMosRuRequest
     */
    public function setStart($start)
    {
      $this->start = $start;
      return $this;
    }

}
