<?php

namespace AppBundle\Sluggable\Handler;

use AppBundle\Entity\Owner;
use Gedmo\Sluggable\Handler\TreeSlugHandler as BaseTreeSlugHandler;
use Gedmo\Sluggable\Mapping\Event\SluggableAdapter;
use Gedmo\Tool\Wrapper\AbstractWrapper;

class TreeSlugHandler extends BaseTreeSlugHandler
{
    /**
     * @inheritdoc
     */
    public function onSlugCompletion(SluggableAdapter $ea, array &$config, $object, &$slug)
    {
        parent::onSlugCompletion($ea, $config, $object, $slug);
        $options = $config['handlers'][get_called_class()];

        if (isset($options['ownerSuffix'])) {
            $wrapped = AbstractWrapper::wrap($object, $this->om);
            $owner = $wrapped->getPropertyValue($options['ownerSuffix']);
            if($owner instanceof Owner && $owner->getName() !== Owner::OWNER_STROI_MOS) {
                $slug .= '-' . $owner->getName();
            }
        }
    }
}
