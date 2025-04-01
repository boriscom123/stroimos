<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class VideoPicksAdmin extends Admin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('video.title', null, array('label' => 'Заголовок видео'))
            ->addIdentifier('video.source', null, array('label' => 'Ведомство, в ведении которого находится информация'))
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('video', 'sonata_type_model_list',
            [
                'label' => 'Видео',
                'required' => true,
                'btn_add' => false,
                'btn_delete' => false,
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
