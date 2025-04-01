<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MetroLineAdmin extends Admin
{
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
        $list->add('color');
        $list->add('number');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('color');
        $form->add('number');

        if (!$form->has('relatedGalleries')) {
            $form->add('relatedGalleries', 'sonata_type_model_autocomplete', array(
                'label' => 'Галереи',
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false
            ));
        }
    }
}
