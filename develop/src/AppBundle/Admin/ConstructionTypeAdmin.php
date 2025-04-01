<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ConstructionTypeAdmin extends Admin
{
    protected $datagridValues = [
        '_sort_by' => 'title',
        '_sort_order'=> 'ASC',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
        $collection->remove('show');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
        $list->add('alias');
//        $list->add('codeGroup');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('title');
        $form->add('alias', null, ['required' => false]);
        $form->add('codeGroup', 'text', ['label' => 'ID Категорий из шины (разделитель ;)']);
    }
}
