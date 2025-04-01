<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AdministrativeAreaAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('title');
        $form->add('pageTitle', null, ['required' => false]);
        $form->add('slug', null, ['required' => false]);
        $form->add(
            'image',
            'sonata_type_model_list',
            ['required' => true],
            ['link_parameters' => ['lock_context' => ['main_image', 'gallery_media']]]
        );
        $form->add('abbreviation');
        $form->add('description', 'ckeditor', ['required' => false, 'label' => 'Описание']);
        $form->add('content', 'ckeditor', ['required' => false]);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
    }
}
