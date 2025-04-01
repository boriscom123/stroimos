<?php
namespace AppBundle\Admin;

use AppBundle\Entity\UnsubscribeReason;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class UnsubscribeReasonAdmin extends Admin
{
    protected $datagridValues = array(
        '_sort_by' => 'createdAt',
        '_sort_order' => 'DESC',
    );

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('email');
        $filter->add('reason', null, [], 'choice', [
            'choices' => array_combine(
                UnsubscribeReason::REASONS,
                array_map(function($item) { return "form.{$item}"; },UnsubscribeReason::REASONS)
            ),
            'multiple' => false,
            'expanded' => false,
        ]);
    }


    protected function configureListFields(ListMapper $list)
    {
        $list->add('email', null, ['label' => 'Email']);
        $list->add('createdAt', null, ['label' => 'Создан']);
        $list->add('reason', null, ['label' => 'Причина', 'template' => ':Admin:UnsubscribeReason/reason_list_field.html.twig']);
        $list->add('comment', null, ['label' => 'Комментарий']);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('email', 'email');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('create');
    }
}
