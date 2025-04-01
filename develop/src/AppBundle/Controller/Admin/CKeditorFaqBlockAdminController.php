<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Exception\ModelDeleteErrorException;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\MediaBundle\Controller\GalleryAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CKeditorFaqBlockAdminController extends GalleryAdminController
{
    use BaseAdminControllerTrait;

    /**
     * @inheritdoc
     */
    public function browseAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render(':Admin/CKEditor:browse.html.twig', array(
            'action' => 'browse',
            'form' => $formView,
            'datagrid' => $datagrid,
        ));
    }

    /**
     * @inheritdoc
     */
    public function deleteAction($id)
    {
        $this->checkUserOwnerAccess($id);
        try {
            return parent::deleteAction($id);
        } catch (ModelDeleteErrorException $e) {
            $this->addFlash('sonata_flash_error', $e->getMessage());

            return new RedirectResponse($this->admin->generateUrl('edit', ['id' => $id]));
        }
    }

    /**
     * @inheritdoc
     */
    public function editAction($id = null)
    {
        $this->checkUserOwnerAccess($id);
        return parent::editAction($id);
    }

    /**
     * @inheritdoc
     */
    public function batchActionDelete(ProxyQueryInterface $query)
    {
        $this->checkUserOwnerAccess();
        return parent::batchActionDelete($query);
    }

    /**
     * @inheritdoc
     */
    protected function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @inheritdoc
     */
    protected function getEditLocker()
    {
        return $this->container->get('admin.edit_locker');
    }
}
