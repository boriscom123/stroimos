<?php
namespace ExtraBundle\Admin;

use ExtraBundle\Entity\EventFeedback;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class EventFeedbackAdmin extends Admin
{
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'createdAt'
    );

    protected $parentAssociationMapping = 'event';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('category', 'doctrine_orm_callback', array(
                    'label' => 'Категория',
                    'callback' => function ($queryBuilder, $alias, $field, $value) {
                        if (!$value['value']) {
                            return null;
                        }
                        $queryBuilder
                            ->andWhere("$alias.category = :category")
                            ->setParameter('category', $value['value'])
                        ;
                        return true;
                    },
                    'field_type' => 'choice',
                    'field_options' => array('choices' => EventFeedback::$categoryList))
            )
            ->add('createdAt', 'date_range_filter', array('label' => 'Дата'), 'date_range')
            ->add('user', null, array('label' => 'Отправитель'))
            ->add('message')
        ;
    }


    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('id')
            ->add('category', 'choice', [
                'choices' => EventFeedback::$categoryList
            ])
            ->add('createdAt')
            ->add('from', 'string', [
                'sortable' => false,
                'label' => 'Отправитель',
                'template' => ':Admin:ErrorReport/from_list_field.html.twig'
            ])
            ->add('message')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                )
            ))
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $from = $this->getConfigurationPool()->getContainer()->get('templating')
            ->render(':Admin/ErrorReport:from_form_as_help.html.twig', [
                'object' => $this->getSubject()
            ]);

        $form
            ->add('category', 'choice', [
                'choices' => EventFeedback::$categoryList,
                'help' => $from
            ])
            ->add('createdAt', 'sonata_type_datetime_picker', array(
                'label' => 'Дата создания',
                'read_only' => true,
                'required' => false,
                'dp_pick_time' => true,
                'dp_language' => 'ru',
                'dp_use_seconds' => false,
                'format' => 'dd/MM/yyyy HH:mm'
            ))
            ->add('message', 'textarea', [
                'read_only' => true
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('id')
            ->add('category', 'choice', [
                'choices' => EventFeedback::$categoryList,
                'label' => 'Категория'
            ])
            ->add('from', 'string', [
                'label' => 'Отправитель',
                'template' => ':Admin:ErrorReport/from_show_field.html.twig'
            ])
            ->add('message', 'text', [
                'label' => 'Сообщение'
            ])
        ;
    }


    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('admin.event.feedback.create');
        $collection->remove('edit');
    }
}
