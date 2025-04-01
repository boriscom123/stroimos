<?php

namespace Amg\DataCore\Model\PublishableInRss;


interface PublishableInRssInterface
{
    /**
     * @return boolean
     */
    public function isPublishableInRss();

    /**
     * @param boolean $publishableInRss
     * @return $this
     */
    public function setPublishableInRss($publishableInRss);
}
