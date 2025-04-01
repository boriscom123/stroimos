<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class MetroTimelineYearAdmin extends Admin
{
    protected $maxPerPage = 2500;
    protected $maxPageLinks = 2500;

    protected $datagridValues = [
        '_sort_by' => 'year',
        '_sort_order' => 'DESC',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('batch_upload', 'batch_upload');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('year')
            ->add('_action', 'actions', ['actions' => [
                'edit' => [],
                'delete' => [],
            ]]);
        ;
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $yearRange = range(date('Y') + 15, 1935);

        $form->add('year', 'choice', [
            'choices' => array_combine($yearRange, $yearRange)
        ]);

        $form->add('x', null, ['label' => 'Координаты центра по X'])
            ->add('y', null, ['label' => 'Координаты центра по Y']);
    }
}
