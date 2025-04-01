<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AuthorAdmin extends Admin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
        $collection->remove('show');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title', null, array('label' => 'ФИО'));
    }


    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title', null, array('label' => 'ФИО'));
        $list->add('weight', null, array('label' => 'Вес'));
        $list->add('_action', 'actions', [
            'label' => 'Действия',
            'actions' => [
            'edit' => [],
            'delete' => [],
        ]]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('title', 'text', array('label' => 'ФИО', 'required' => true));
        $form->add('weight', 'integer', array('label' => 'Вес', 'required' => true));
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $rootAliases = $query->getRootAliases();
        $rootAlias = reset($rootAliases);

        $query->addOrderBy($rootAlias.'.weight', 'DESC');
        $query->addOrderBy($rootAlias.'.title', 'ASC');

        return $query;
    }

}
