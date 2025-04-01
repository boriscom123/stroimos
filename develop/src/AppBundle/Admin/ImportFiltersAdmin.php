<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ImportFiltersAdmin extends Admin
{
    protected $datagridValues = [
        '_sort_by' => 'daily',
        '_sort_order'=> 'DESC',
    ];
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
        $collection->remove('show');
        $collection->remove('batch');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->remove('batch');
        $list->add('id');
        $list->addIdentifier('title');
        $list->add('filter', 'list');
        $list->add('daily');
        $list->add('_action', 'actions', ['actions' => ['edit' => [],'delete' => [],]]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('title')
            ->add('filter', 'textarea', [
                'help' => '%-1 day% - минус один день от текущей даты<br>%значение% - искать вхождение значения<br>%значение - заканчивается на значение<br>значение% - начинается на значение<br>значение - точный поиск',
                'attr' => ['rows' => 10]
            ])
            ->add('daily', 'checkbox', ['required' => false, 'label' => 'Ежедневный', 'label_attr' => ['style' => 'float: left; padding-right: 0.8em;'],])
            ;
    }
}
