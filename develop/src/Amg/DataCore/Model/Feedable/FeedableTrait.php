<?php

namespace Amg\DataCore\Model\Feedable;

trait FeedableTrait
{
    /**
     * @var boolean
     *
     * @Doctrine\ORM\Mapping\Column(type="boolean", nullable=true)
     */
    protected $feedable;

    /**
     * @param boolean $feedable
     * @return $this
     */
    public function setFeedable($feedable)
    {
        $this->feedable = $feedable;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isFeedable()
    {
        return $this->feedable;
    }
}
