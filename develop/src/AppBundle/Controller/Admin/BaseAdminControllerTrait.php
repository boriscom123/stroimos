<?php

namespace AppBundle\Controller\Admin;

use Amg\Bundle\AdminBundle\Admin\EditLocker\EditLocker;
use AppBundle\Exception\AccessDeniedByOwnerException;
use AppBundle\Model\BaseOwner;
use AppBundle\Model\MultiOwner;
use AppBundle\Model\SingleOwner;
use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait BaseAdminControllerTrait
{
    /**
     * Get a user from the Security Token Storage.
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    abstract public function getUser();

    /**
     * Shortcut to return the request service.
     *
     * @return Request
     *
     * @deprecated since version 2.4, to be removed in 3.0.
     *             Ask Symfony to inject the Request object into your controller
     *             method instead by type hinting it in the method's signature.
     */
    abstract public function getRequest();


    /**
     * @return \Sonata\AdminBundle\Admin\AdminInterface
     */
    abstract protected function getAdmin();

    /**
     * @return EditLocker
     */
    abstract protected function getEditLocker();

    /**
     * @return \AppBundle\Entity\Owner|null
     */
    protected function getUserOwner()
    {
        $user = $this->getUser();

        if($user instanceof SingleOwner) {
            return $user->getOwner();
        }

        return null;
    }

    /**
     * @param int|null $id
     * @throws AccessDeniedByOwnerException
     */
    protected function checkUserOwnerAccess($id = null)
    {
        $owner = $this->getUserOwner();
        if($owner === null) {
            return;
        }
        $request = $this->getRequest();
        $actionName = explode('::', $request->attributes->get('_controller'))[1];
        if($actionName === 'batchActionDelete' || $actionName === 'deleteAction') {
            throw new AccessDeniedByOwnerException();
        }

        if($id === null) {
            return;
        }

        if($request->isMethod('GET')) {
            return;
        }

        $object = $this->getAdmin()->getSubject();
        if($object instanceof BaseOwner && !$object->hasOwner($owner)) {
            throw new AccessDeniedByOwnerException();
        }
    }

    /**
     * Link action.
     *
     * @param Request $request
     * @param int|string $id
     *
     * @return JsonResponse
     */
    public function linkAction(Request $request, $id)
    {
        return $this->processLink($request, $id, true);
    }

    /**
     * Unlink action.
     *
     * @param Request $request
     * @param int|string $id
     *
     * @return JsonResponse
     */
    public function unlinkAction(Request $request, $id)
    {
        return $this->processLink($request, $id, false);
    }

    /**
     * @param Request $request
     * @param int|string $id
     * @param bool $doLink
     *
     * @return JsonResponse
     */
    protected function processLink(Request $request, $id, $doLink)
    {
        if ($request->isMethod('GET')) {
            return new JsonResponse('Неправильно составлен запрос', 400);
        }

        $admin = $this->getAdmin();
        $object = $admin->getObject($id);

        if (!$object) {
            return new JsonResponse('Материал не найден', 404);
        }

        if (false === $admin->isGranted('EDIT', $object)) {
            return new JsonResponse('Недостаточно прав', 403);
        }

        $editLocker = $this->getEditLocker();
        $entityLock = $editLocker->getLock($object);

        /** @var User $user */
        $user = $this->getUser();
        if($user->getOwner() === null) {
            return new JsonResponse('Пользователь не привязан к организации', 400);
        }

        if($entityLock->getOwner()->getId() !== $user->getId()) {
            return new JsonResponse('Материал находится на редактировании, попробуйте позже', 400);
        }

        if(!$object instanceof MultiOwner) {
            return new JsonResponse('Материал нельзя привязать к организации', 400);
        }

        $owner = $this->getUserOwner();
        if($doLink) {
            if($object->hasOwner($owner)) {
                return new JsonResponse('Материал успешно привязан к организации');
            }
        } else {
            if(!$object->hasOwner($owner)) {
                return new JsonResponse('Материал успешно отвязан от организации');
            }
        }

        if($doLink) {
            $object->getOwners()->add($owner);
        } else {
            $object->getOwners()->removeElement($owner);
        }

        $admin->update($object);
        $message = $doLink ? 'привязан к' : 'отвязан от';

        return new JsonResponse(sprintf('Материал успешно %s организации', $message));
    }
}