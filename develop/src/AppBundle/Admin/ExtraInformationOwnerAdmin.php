<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ExtraInformationOwnerAdmin extends Admin
{
    protected $baseRouteName = 'extra_information';

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('title', null, ['read_only' => true])
            ->add('extraInformation', 'sonata_type_admin', [
                'delete' => false,
                'required' => false,
                'btn_add' => false,
                'btn_list' => false,
                'btn_delete' => false,
                'btn_catalogue' => false,
            ])
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('line');
    }
}
