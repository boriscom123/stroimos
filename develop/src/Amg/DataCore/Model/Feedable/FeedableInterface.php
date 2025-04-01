<?php

namespace Amg\DataCore\Model\Feedable;


interface FeedableInterface
{
    /**
     * @return boolean
     */
    public function isFeedable();

    /**
     * @param boolean $feedable
     * @return $this
     */
    public function setFeedable($feedable);
}
