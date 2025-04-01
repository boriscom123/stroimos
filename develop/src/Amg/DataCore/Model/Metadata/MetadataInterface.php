<?php
namespace Amg\DataCore\Model\Metadata;

use Amg\DataCore\Model\Entitled\EntitledInterface;

interface MetadataInterface extends EntitledInterface
{
    public function getMetaDescription();

    public function getMetaKeywords();
}
