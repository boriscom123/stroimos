<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CategoryAdmin extends Admin
{
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id');
        $list->addIdentifier('title');
    }

    public function configureFormFields(FormMapper $form)
    {
        $form->
        tab('Основное')
            ->with('Контент')
                ->add('alias')
            ->end()
        ->end()
        ;

    }
}
