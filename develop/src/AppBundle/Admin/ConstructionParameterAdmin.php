<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ConstructionParameterAdmin extends Admin
{
    protected $datagridValues = [
        '_sort_by' => 'title',
        '_sort_order'=> 'ASC',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
        $collection->remove('show');
        $collection->remove('batch');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('title');
    }
}
