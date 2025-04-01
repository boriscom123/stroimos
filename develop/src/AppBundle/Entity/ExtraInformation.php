<?php

namespace AppBundle\Entity;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Amg\Bundle\AdminBundle\Model\LockableEntityTrait;
use Amg\DataCore\Model\Contentful\ContentfulInterface;
use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Amg\DataCore\Model\Timestampable\TimestampableInterface;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ExtraInformation implements
    IdentifiableInterface,
    LockableEntity,
    ContentfulInterface,
    TimestampableInterface
{
    use IdentifiableTrait,
        ContentfulTrait,
        TimestampableTrait,
        ORMBehaviors\Blameable\Blameable,
        LockableEntityTrait;
}
