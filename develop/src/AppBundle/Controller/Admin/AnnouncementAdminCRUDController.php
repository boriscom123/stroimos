<?php

namespace AppBundle\Controller\Admin;

use Amg\DataCore\Model\Publishable\PublishableTrait;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AnnouncementAdminCRUDController extends Controller
{
    public function togglePublishableAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        /** @var PublishableTrait $object */
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('Unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('EDIT', $object)) {
            throw new AccessDeniedException();
        }
        $object->setPublishable(!$object->isPublishable());

        $this->admin->getModelManager()->update($object);

        return $this->renderJson(['result' => 'ok']);
    }
}
