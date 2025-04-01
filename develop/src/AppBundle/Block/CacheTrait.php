<?php
namespace AppBundle\Block;

trait CacheTrait
{
    protected $useCache = false;

    /**
     * @param $useCache bool
     */
    public function setCache($useCache) {
        $this->useCache = $useCache;
    }
}