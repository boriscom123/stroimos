<?php

namespace AppBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CRUDController extends Controller {

    public function revertRevisionAction($id, $base_rev_id, $compare_rev_id, $field_name)
    {
        $object = $this->admin->getObject($id);

        $objectClass = $this->admin->getClass();

        $auditManager = $this->get('sonata.admin.audit.manager');
        $auditReader = $auditManager->getReader($objectClass);

        $compareRevision = $auditReader->find($objectClass, $id, $compare_rev_id);

        $propertyAccessor = new PropertyAccessor();

        $compareFieldValue = $propertyAccessor->getValue($compareRevision, $field_name);

        $propertyAccessor->setValue($object, $field_name, $compareFieldValue);

        $this->admin->update($object);

        $revisions = $auditReader->findRevisions($objectClass, $object->getId());
        $baseRevision = current($revisions);

        return $this->redirect($this->admin->generateObjectUrl('history_compare_revisions', $object, array(
            'base_revision' => $baseRevision->getRev(),
            'compare_revision' => $compare_rev_id
        )));
    }


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
}
