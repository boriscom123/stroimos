<?php

namespace AppBundle\Soap\EMoscow\Type;

class DateTimeType
{

    /**
     * @var \DateTime $_
     */
    protected $_ = null;

    /**
     * @var string $type
     */
    protected $type = null;

    /**
     * @var boolean $mandatory
     */
    protected $mandatory = null;

    /**
     * @var boolean $readonly
     */
    protected $readonly = null;

    /**
     * @param \DateTime $_
     * @param string $type
     * @param boolean $mandatory
     * @param boolean $readonly
     */
    public function __construct(\DateTime $_, $type, $mandatory, $readonly)
    {
      $this->_ = $_->format(\DateTime::ATOM);
      $this->type = $type;
      $this->mandatory = $mandatory;
      $this->readonly = $readonly;
    }

    /**
     * @return \DateTime
     */
    public function get_()
    {
      if ($this->_ == null) {
        return null;
      } else {
        try {
          return new \DateTime($this->_);
        } catch (\Exception $e) {
          return false;
        }
      }
    }

    /**
     * @param \DateTime $_
     * @return \AppBundle\Soap\EMoscow\Type\DateTimeType
     */
    public function set_(\DateTime $_)
    {
      $this->_ = $_->format(\DateTime::ATOM);
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
     * @return \AppBundle\Soap\EMoscow\Type\DateTimeType
     */
    public function setType($type)
    {
      $this->type = $type;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getMandatory()
    {
      return $this->mandatory;
    }

    /**
     * @param boolean $mandatory
     * @return \AppBundle\Soap\EMoscow\Type\DateTimeType
     */
    public function setMandatory($mandatory)
    {
      $this->mandatory = $mandatory;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getReadonly()
    {
      return $this->readonly;
    }

    /**
     * @param boolean $readonly
     * @return \AppBundle\Soap\EMoscow\Type\DateTimeType
     */
    public function setReadonly($readonly)
    {
      $this->readonly = $readonly;
      return $this;
    }

}
