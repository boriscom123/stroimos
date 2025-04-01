<?php

namespace AppBundle\Soap\EMoscow\Type;

class UpdateHPSMInteractionsFromMosRuRequest
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
     * @var int $updateconstraint
     */
    protected $updateconstraint = null;

    /**
     * @param HPSMInteractionsFromMosRuModelType $model
     * @param boolean $attachmentInfo
     * @param boolean $attachmentData
     * @param boolean $ignoreEmptyElements
     * @param int $updateconstraint
     */
    public function __construct($model, $attachmentInfo, $attachmentData, $ignoreEmptyElements, $updateconstraint)
    {
      $this->model = $model;
      $this->attachmentInfo = $attachmentInfo;
      $this->attachmentData = $attachmentData;
      $this->ignoreEmptyElements = $ignoreEmptyElements;
      $this->updateconstraint = $updateconstraint;
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
     * @return \AppBundle\Soap\EMoscow\Type\UpdateHPSMInteractionsFromMosRuRequest
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
     * @return \AppBundle\Soap\EMoscow\Type\UpdateHPSMInteractionsFromMosRuRequest
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
     * @return \AppBundle\Soap\EMoscow\Type\UpdateHPSMInteractionsFromMosRuRequest
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
     * @return \AppBundle\Soap\EMoscow\Type\UpdateHPSMInteractionsFromMosRuRequest
     */
    public function setIgnoreEmptyElements($ignoreEmptyElements)
    {
      $this->ignoreEmptyElements = $ignoreEmptyElements;
      return $this;
    }

    /**
     * @return int
     */
    public function getUpdateconstraint()
    {
      return $this->updateconstraint;
    }

    /**
     * @param int $updateconstraint
     * @return \AppBundle\Soap\EMoscow\Type\UpdateHPSMInteractionsFromMosRuRequest
     */
    public function setUpdateconstraint($updateconstraint)
    {
      $this->updateconstraint = $updateconstraint;
      return $this;
    }

}
