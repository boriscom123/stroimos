<?php

namespace Amg\Bundle\PageBundle\Controller\Admin;

use AppBundle\Entity\Block;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class BlockController extends Controller
{
    /**
     * @throws NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        if (!$this->admin->getParent()) {
            throw new NotFoundHttpException('You cannot create a block without a page');
        }

        $parameters = $this->admin->getPersistentParameters();

        $blockServices = $this->get('sonata.block.manager')->getServicesByContext('custom', false);

        if (!$parameters['type']) {
            return $this->render('AmgPageBundle:Admin:Block/select_type_block.html.twig', array(
                'services'      => $blockServices,
                'base_template' => $this->getBaseTemplate(),
                'admin'         => $this->admin,
                'action'        => 'create'
            ));
        }

        return Controller::createAction();
    }

    public function toggleEnableAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        /** @var Block $object */
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('EDIT', $object)) {
            throw new AccessDeniedException();
        }
        $newValue = !$object->getEnabled();
        $object->setEnabled($newValue);
        $object->setSetting('publishable', $newValue);

        $this->admin->getModelManager()->update($object);

        return $this->renderJson(['result' => 'ok']);
    }
}
