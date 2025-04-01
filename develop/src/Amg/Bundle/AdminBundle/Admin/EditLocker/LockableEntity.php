<?php
namespace Amg\Bundle\AdminBundle\Admin\EditLocker;

use Amg\Bundle\AdminBundle\Entity\EntityLock;

interface LockableEntity
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return EntityLock
     */
    public function getEntityLock();

    /**
     * @param EntityLock $entityLock
     *
     * @return $this
     */
    public function setEntityLock($entityLock);
}
