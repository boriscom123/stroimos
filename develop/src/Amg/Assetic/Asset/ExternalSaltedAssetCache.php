<?php
namespace Amg\Assetic\Asset;

use Assetic\Asset\AssetInterface;
use Assetic\Cache\CacheInterface;
use Assetic\Filter\FilterInterface;

class ExternalSaltedAssetCache implements AssetInterface
{
    private $asset;
    private $cache;
    private $salt;

    public function __construct(AssetInterface $asset, CacheInterface $cache, $salt = '')
    {
        $this->asset = $asset;
        $this->cache = $cache;
        $this->salt = $salt;
    }

    public function ensureFilter(FilterInterface $filter)
    {
        $this->asset->ensureFilter($filter);
    }

    public function getFilters()
    {
        return $this->asset->getFilters();
    }

    public function clearFilters()
    {
        $this->asset->clearFilters();
    }

    public function load(FilterInterface $additionalFilter = null)
    {
        $cacheKey = self::getCacheKey($this->asset, $additionalFilter, 'load' . $this->salt);
        if ($this->cache->has($cacheKey)) {
            $this->asset->setContent($this->cache->get($cacheKey));

            return;
        }

        $this->asset->load($additionalFilter);
        $this->cache->set($cacheKey, $this->asset->getContent());
    }

    public function dump(FilterInterface $additionalFilter = null)
    {
        $cacheKey = self::getCacheKey($this->asset, $additionalFilter, 'dump' . $this->salt);
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $content = $this->asset->dump($additionalFilter);
        $this->cache->set($cacheKey, $content);

        return $content;
    }

    public function getContent()
    {
        return $this->asset->getContent();
    }

    public function setContent($content)
    {
        $this->asset->setContent($content);
    }

    public function getSourceRoot()
    {
        return $this->asset->getSourceRoot();
    }

    public function getSourcePath()
    {
        return $this->asset->getSourcePath();
    }

    public function getSourceDirectory()
    {
        return $this->asset->getSourceDirectory();
    }

    public function getTargetPath()
    {
        return $this->asset->getTargetPath();
    }

    public function setTargetPath($targetPath)
    {
        $this->asset->setTargetPath($targetPath);
    }

    public function getLastModified()
    {
        return $this->asset->getLastModified();
    }

    public function getVars()
    {
        return $this->asset->getVars();
    }

    public function setValues(array $values)
    {
        $this->asset->setValues($values);
    }

    public function getValues()
    {
        return $this->asset->getValues();
    }

    /**
     * Returns a cache key for the current asset.
     *
     * The key is composed of everything but an asset's content:
     *
     *  * source root
     *  * source path
     *  * target url
     *  * last modified
     *  * filters
     *
     * @param AssetInterface  $asset            The asset
     * @param FilterInterface $additionalFilter Any additional filter being applied
     * @param string          $salt             Salt for the key
     *
     * @return string A key for identifying the current asset
     */
    private static function getCacheKey(AssetInterface $asset, FilterInterface $additionalFilter = null, $salt = '')
    {
        if ($additionalFilter) {
            $asset = clone $asset;
            $asset->ensureFilter($additionalFilter);
        }

        $cacheKey  = $asset->getSourceRoot();
        $cacheKey .= $asset->getSourcePath();
        $cacheKey .= $asset->getTargetPath();
        $cacheKey .= $asset->getLastModified();

        foreach ($asset->getFilters() as $filter) {
            if ($filter instanceof HashableInterface) {
                $cacheKey .= $filter->hash();
            } else {
                $cacheKey .= serialize($filter);
            }
        }

        if ($values = $asset->getValues()) {
            asort($values);
            $cacheKey .= serialize($values);
        }

        return md5($cacheKey.$salt);
    }
} 