<?php
namespace Amg\Bundle\AdminBundle\Controller;

use Amg\Bundle\AdminBundle\Admin\EditLocker\EditLocker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LockingController extends Controller
{
    public function updateLockAction($code, $id)
    {
        $object = $this->getObject($id, $code);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        /** @var EditLocker $editLocker */
        $editLocker = $this->container->get('admin.edit_locker');

        $entityLock = $editLocker->getLock($object);

        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $lockOwner = $entityLock->getOwner();
        $isReadOnly = $lockOwner !== $currentUser;

        $lockOwnerName = $lockOwner->getFullname() ?: $lockOwner->getUsername();

        return new Response(json_encode([
            'isReadOnly' => $isReadOnly,
            'lockingUserName' => $isReadOnly ? $lockOwnerName : '',
        ]));
    }

    public function unlockAction($code, $id)
    {
        $object = $this->getObject($id, $code);
        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $editLocker = $this->container->get('admin.edit_locker');
        $editLocker->overrideLock($object);

        return $this->redirect($this->getAdmin($code)->generateObjectUrl('edit', $object));
    }

    protected function getObject($id, $adminCode)
    {
        $admin = $this->get('sonata.admin.pool')->getAdminByAdminCode($adminCode);

        return $admin->getObject($id);
    }

    protected function getAdmin($adminCode)
    {
        return $this->get('sonata.admin.pool')->getAdminByAdminCode($adminCode);
    }
}
