<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class RoadParameterValueAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('constructionParameter', null, [
            'required' => true
        ]);
        $form->add('value', 'ckeditor', ['required' => true]);
        $form->add('weight', null, ['required' => true]);
    }
}
