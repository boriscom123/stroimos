<?php

namespace AppBundle\Controller\Admin;

use Sonata\MediaBundle\Controller\MediaAdminController as BaseMediaAdminController;

class CKeditorPhotoLineAdminController extends BaseMediaAdminController
{
    public function browserAction()
    {
        $admin = $this->admin;
        $datagrid = $admin->getDatagrid();
        $datagrid->setValue('context', null, $this->admin->getPersistentParameter('context'));
        $datagrid->setValue('providerName', null, $this->admin->getPersistentParameter('provider'));

        $formats = array();

        foreach ($datagrid->getResults() as $media) {
            $formats[$media->getId()] = $this->get('sonata.media.pool')->getFormatNamesByContext($media->getContext());
        }

        $formView = $datagrid->getForm()->createView();

        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render(':Admin/SonataFormatter:browser.html.twig', array(
            'action' => 'browser',
            'form' => $formView,
            'datagrid' => $datagrid,
            'formats' => $formats
        ));
    }
}