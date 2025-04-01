<?php
namespace Amg\Bundle\AdminBundle\Entity\Listener;

use Amg\Bundle\AdminBundle\Entity\EntityLock;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class EntityLockListener
{
    use ContainerAwareTrait;

    public function prePersist(EntityLock $entityLock/*, LifecycleEventArgs $event*/)
    {
        $this->setUser($entityLock);
    }

    public function preUpdate(EntityLock $entityLock/*, PreUpdateEventArgs $event*/)
    {
        $this->setUser($entityLock);
    }

    private function setUser(EntityLock $entityLock)
    {
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();

        if ($currentUser) {
            $entityLock->setOwner($currentUser);
        }
    }
}
