<?php

namespace AppBundle\Seo;


class SitemapSection
{
    /**
     * @var string
     */
    protected $section;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $frequency;

    public function __construct($section, $class, $frequency)
    {
        $this->section = $section;
        $this->class = $class;
        $this->frequency = $frequency;
    }


    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param string $frequency
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }
} 