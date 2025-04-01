<?php

namespace AppBundle\Soap\EMoscow\Type;

class ByteType
{

    /**
     * @var int $_
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
     * @param int $_
     * @param string $type
     * @param boolean $mandatory
     * @param boolean $readonly
     */
    public function __construct($_, $type, $mandatory, $readonly)
    {
      $this->_ = $_;
      $this->type = $type;
      $this->mandatory = $mandatory;
      $this->readonly = $readonly;
    }

    /**
     * @return int
     */
    public function get_()
    {
      return $this->_;
    }

    /**
     * @param int $_
     * @return \AppBundle\Soap\EMoscow\Type\ByteType
     */
    public function set_($_)
    {
      $this->_ = $_;
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
     * @return \AppBundle\Soap\EMoscow\Type\ByteType
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
     * @return \AppBundle\Soap\EMoscow\Type\ByteType
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
     * @return \AppBundle\Soap\EMoscow\Type\ByteType
     */
    public function setReadonly($readonly)
    {
      $this->readonly = $readonly;
      return $this;
    }

}
