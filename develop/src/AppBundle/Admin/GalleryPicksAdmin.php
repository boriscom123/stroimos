<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class GalleryPicksAdmin extends Admin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('gallery.title', null, array('label' => 'Заголовок галереи'))
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('gallery', 'sonata_type_model_list',
            [
                'label' => 'Галерея',
                'required' => true,
                'btn_add' => false,
                'btn_delete' => false
            ],
            [
                'link_parameters' => ['filter' => ['publishable' => ['value' => 1]]]
            ]
        );
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'edit']);
    }
}
