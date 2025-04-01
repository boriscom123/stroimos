<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ArticleSourceAdmin extends Admin
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

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title', null, array('label' => 'Название ведомства'));
    }


    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title', null, array('label' => 'Название ведомства'));
        $list->add('_action', 'actions', [
            'label' => 'Действия',
            'actions' => [
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('title', 'text', array('label' => 'Название ведомства', 'required' => true))
            ->add('url', 'url', array('label' => 'Адрес сайта', 'required' => false))
        ;
    }
}
