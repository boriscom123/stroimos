<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EmbeddableContentAdminController extends BaseAdminController
{
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
