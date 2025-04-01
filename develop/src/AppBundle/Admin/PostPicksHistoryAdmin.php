<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class PostPicksHistoryAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('date')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('date')
        ;
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('date', 'sonata_type_date_picker', array(
                'dp_min_date' => '1-1-2000',
                'dp_language' => 'ru',
                'required' => true,
                'format' => 'dd-MM-yyyy',
            ))
            ->add('posts', 'sonata_type_model_autocomplete', array(
                'label' => 'Публикации',
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false
            ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'edit', 'create', 'delete', 'batch', 'export']);
    }
}
