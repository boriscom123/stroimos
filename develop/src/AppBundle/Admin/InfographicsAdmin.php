<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Infographics;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class InfographicsAdmin extends Admin
{
    public $supportsPreviewMode = true;

    protected $datagridValues = [
        '_sort_by' => 'createdAt',
        '_sort_order' => 'DESC',
    ];

    protected function configureFormFields(FormMapper $form)
    {
        $form->tab('Основное')->with('Параметры')
            ->add('type', 'choice', ['choices' => Infographics::$typeLabels, 'required' => true, 'label' => 'Тип'])
            ->add('isVisibleOnHomepage', null, ['required' => false, 'label' => 'Отображать на главной странице'])
        ->end()->end();
        $form->add('infographics', 'sonata_type_model_list', ['label' => 'Инфографика'], ['link_parameters' => ['context' => 'infographics', 'lock_context' => true]]);
    }

    protected function configureDatagridFilters(DatagridMapper $dataMapper)
    {
        $dataMapper
            ->add('title')
            ->add('publishable')
            ->add('isVisibleOnHomepage')
            ->add('source')
            ->add('publishStartDate')
            ->add('publishEndDate')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('author')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('publishable')
            ->add('isVisibleOnHomepage')
            ->add('publishStartDate')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('publishable')
            ->add('publishStartDate')
            ->add('publishEndDate')
            ->add('publishableInRss')
            ->add('author')
            ->add('title')
            ->add('teaser')
            ->add('content')
            ->add('image')
            ->add('infographics')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('revert_revision', '{id}/history/{base_rev_id}/{compare_rev_id}/revert/{field_name}');
        $collection->add('browse', 'browse');
    }



}
