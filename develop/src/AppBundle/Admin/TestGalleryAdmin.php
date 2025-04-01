<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TestGalleryAdmin extends Admin
{
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id');
    }

    public function configureFormFields(FormMapper $form)
    {
        $gallery = $this->getSubject();
        $form->add('image', 'file', array('multiple' => true));
    }
}
