<?php
namespace Amg\Bundle\AdminBundle\Entity\Repository;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Amg\Bundle\AdminBundle\Entity\EntityLock;
use Amg\DataCore\ValueObject\EntityReference;
use Doctrine\ORM\EntityRepository;

class EntityLockRepository extends EntityRepository
{
    /**
     * @param \Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity $entity
     *
     * @return \Amg\Bundle\AdminBundle\Entity\EntityLock|null
     */
    public function findByEntity(LockableEntity $entity)
    {
        return $this->find((string)EntityReference::createFromEntity($entity));
    }

    public function createFromEntity(LockableEntity $object)
    {
        $entityLock = new EntityLock($object);

        $this->save($entityLock);

        return $entityLock;
    }

    public function remove(EntityLock $entityLock)
    {
        $em = $this->getEntityManager();
        $em->remove($entityLock);
        $em->flush($entityLock);
    }

    public function update(EntityLock $entityLock)
    {
        $entityLock->setUpdatedAt(new \DateTime());

        $this->save($entityLock);
    }

    private function save(EntityLock $entityLock)
    {
        $em = $this->getEntityManager();

        $em->persist($entityLock);
        $em->flush($entityLock);
    }
}
