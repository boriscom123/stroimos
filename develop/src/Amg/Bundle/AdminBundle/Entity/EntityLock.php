<?php
namespace Amg\Bundle\AdminBundle\Entity;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Amg\DataCore\ValueObject\EntityReference;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="Amg\Bundle\AdminBundle\Entity\Repository\EntityLockRepository")
 * @ORM\EntityListeners({"Amg\Bundle\AdminBundle\Entity\Listener\EntityLockListener"})
 */
class EntityLock
{
    use ORMBehaviors\Timestampable\Timestampable;

    const TTL = 10;

    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    private $entityReference;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     */
    private $owner;

    public function __construct(LockableEntity $entity)
    {
        $this->entityReference = (string)EntityReference::createFromEntity($entity);
    }

    /**
     * @return string
     */
    public function getEntityReference()
    {
        return $this->entityReference;
    }

    /**
     * @param string $entityReference
     *
     * @return $this
     */
    public function setEntityReference($entityReference)
    {
        $this->entityReference = $entityReference;

        return $this;
    }

    /**
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param \Application\Sonata\UserBundle\Entity\User $owner
     *
     * @return $this
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    public function isExpired()
    {
        return (new \DateTime())->getTimestamp() - $this->getUpdatedAt()->getTimestamp() > self::TTL;
    }
}
