<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class OwnerAdmin extends Admin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name', null, ['label' => 'Название'])
            ->add('organization.title')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name', null, [])
            ->add('organization', 'sonata_type_model_autocomplete', [
                'label' => 'Организация',
                'required' => true,
                'property' => 'title'
            ]);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        //$collection->clearExcept(['list', 'edit']);
    }
}
