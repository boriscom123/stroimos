<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class InfographicsRubricAdmin extends Admin
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
        $list->add('_action', 'actions', ['actions' => [
            'edit' => [],
            'delete' => [],
        ]]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('title');
    }
}
