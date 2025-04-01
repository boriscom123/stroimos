<?php

namespace Amg\DataCore\Model\Publishable;

trait PublishableTrait
{
    /**
     * @var boolean
     *
     * @Doctrine\ORM\Mapping\Column(name="publishable", type="boolean")
     */
    protected $publishable = false;

    /**
     * Set isPublishable
     *
     * @param boolean $publishable
     * @return $this
     */
    public function setPublishable($publishable)
    {
        $this->publishable = $publishable;

        return $this;
    }

    /**
     * Get isPublishable
     *
     * @return boolean
     */
    public function isPublishable()
    {
        return $this->publishable;
    }
}
