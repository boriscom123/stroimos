<?php

namespace Amg\DataCore\Model\PublishableInRss;

trait PublishableInRssTrait
{
    /**
     * @var boolean
     *
     * @Doctrine\ORM\Mapping\Column(type="boolean")
     */
    protected $publishableInRss = true;

    /**
     * @param boolean $publishableInRss
     * @return $this
     */
    public function setPublishableInRss($publishableInRss)
    {
        $this->publishableInRss = $publishableInRss;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isPublishableInRss()
    {
        return $this->publishableInRss;
    }
}
