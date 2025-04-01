<?php

namespace Amg\DataCore\Model\Publishable;


interface PublishableInterface
{
    /**
     * Is content published now
     *
     * @return boolean
     */
    public function isPublishable();

    /**
     * Set content is publishable
     *
     * @param boolean $publishable
     * @return $this
     */
    public function setPublishable($publishable);
}
