<?php
namespace Amg\Assetic\Controller;

use Amg\Assetic\Asset\ExternalSaltedAssetCache;
use Assetic\Asset\AssetInterface;
use Symfony\Bundle\AsseticBundle\Controller\AsseticController;

class DependencyAwareAsseticController extends AsseticController
{
    protected function cachifyAsset(AssetInterface $asset)
    {
        if ($vars = $asset->getVars()) {
            if (null === $this->valueSupplier) {
                throw new \RuntimeException(sprintf('You must configure a value supplier if you have assets with variables.'));
            }

            $asset->setValues(array_intersect_key($this->valueSupplier->getValues(), array_flip($vars)));
        }

        return new ExternalSaltedAssetCache($asset, $this->cache, $this->am->getLastModified($asset));
    }
} 