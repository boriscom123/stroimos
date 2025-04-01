<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class ExtraInformationAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('content', 'ckeditor', [
            'required' => false,
            'config' => [
                'width' => '800px'
            ]
        ]);
    }
}
