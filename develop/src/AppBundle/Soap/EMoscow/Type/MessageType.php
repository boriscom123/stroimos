<?php

namespace AppBundle\Soap\EMoscow\Type;

class MessageType extends StringType
{

    /**
     * @var StringType $_
     */
    protected $_ = null;

    /**
     * @var int $severity
     */
    protected $severity = null;

    /**
     * @var string $module
     */
    protected $module = null;

    /**
     * @param string $_
     * @param string $type
     * @param boolean $mandatory
     * @param boolean $readonly
     * @param StringType $_
     * @param int $severity
     * @param string $module
     */
    public function __construct($_, $type, $mandatory, $readonly, $severity, $module)
    {
      parent::__construct($_, $type, $mandatory, $readonly);
      $this->_ = $_;
      $this->severity = $severity;
      $this->module = $module;
    }

    /**
     * @return StringType
     */
    public function get_()
    {
      return $this->_;
    }

    /**
     * @param StringType $_
     * @return \AppBundle\Soap\EMoscow\Type\MessageType
     */
    public function set_($_)
    {
      $this->_ = $_;
      return $this;
    }

    /**
     * @return int
     */
    public function getSeverity()
    {
      return $this->severity;
    }

    /**
     * @param int $severity
     * @return \AppBundle\Soap\EMoscow\Type\MessageType
     */
    public function setSeverity($severity)
    {
      $this->severity = $severity;
      return $this;
    }

    /**
     * @return string
     */
    public function getModule()
    {
      return $this->module;
    }

    /**
     * @param string $module
     * @return \AppBundle\Soap\EMoscow\Type\MessageType
     */
    public function setModule($module)
    {
      $this->module = $module;
      return $this;
    }

}
