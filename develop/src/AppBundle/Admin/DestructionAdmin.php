<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DestructionAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with('Адрес', array('class' => 'col-md-6'))
                ->add('administrativeUnit', 'sonata_type_model', [
                    'required' => false,
                    'property' => 'displayTitle',
                ])
                ->add('address', 'address', array('label' => false, 'required' => true))
            ->end()
            ->with('Параметры', array('class' => 'col-md-6'))
                ->add('series', 'text', array('label' => 'Серия'))
                ->add('destructionYear', 'integer', array(
                    'label' => 'Год сноса',
                    'attr' => array(
                        'min' => '2010',
                    )))
                ->add('destructionQuarter', 'integer', array('label' => 'Квартал сноса'))
                ->add('destructed', 'checkbox', array('label' => 'Снесён', 'required' => false))
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id');
        $list->addIdentifier('address');
        $list->add('destructed');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('administrativeUnit')
//            ->add('address.text')
            ->add('destructed')
        ;
    }
}
