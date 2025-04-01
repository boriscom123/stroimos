<?php
namespace Amg\Bundle\AdminBundle\Admin\EditLocker;

use Amg\Bundle\AdminBundle\Entity\EntityLock;
use Amg\Bundle\AdminBundle\Entity\Repository\EntityLockRepository;
use Symfony\Component\Security\Core\SecurityContext;

class EditLocker
{
    /**
     * @var EntityLockRepository
     */
    private $repository;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    private $securityContext;

    public function __construct(SecurityContext $securityContext, EntityLockRepository $lockRepository)
    {
        $this->repository = $lockRepository;
        $this->securityContext = $securityContext;
    }

    /**
     * @param LockableEntity $entity
     *
     * @return \Amg\Bundle\AdminBundle\Entity\EntityLock
     */
    public function getLock($entity)
    {
        /** @var EntityLock $entityLock */
        $entityLock = $this->repository->findByEntity($entity);

        // unlocked: create new lock
        if (!$entityLock) {
            return $this->repository->createFromEntity($entity);
        }

        // locked, but lock has expired: update owner and timestamp
        if ($entityLock->isExpired()) {
            $this->repository->update($entityLock);
        }
        // locked by current user: update timestamp
        elseif ($entityLock->getOwner() === $this->securityContext->getToken()->getUser()) {
            $this->repository->update($entityLock);
        }

        // locked by someone else: return as is
        return $entityLock;
    }

    public function overrideLock(LockableEntity $entity)
    {
        if ($this->securityContext->isGranted('ROLE_ADMIN')) {
            $lock = $this->repository->findByEntity($entity);
            if ($lock) {
                $this->repository->update($lock);
            }
        }
    }
}
