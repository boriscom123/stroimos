<?php
namespace Amg\Bundle\AdminBundle\Model;

use Amg\Bundle\AdminBundle\Entity\EntityLock;

trait LockableEntityTrait
{
    /** @var EntityLock */
    private $entityLock;

    /**
     * @return EntityLock
     */
    public function getEntityLock()
    {
        return $this->entityLock;
    }

    /**
     * @param EntityLock $entityLock
     *
     * @return LockableEntityTrait
     */
    public function setEntityLock($entityLock)
    {
        $this->entityLock = $entityLock;

        return $this;
    }
}
