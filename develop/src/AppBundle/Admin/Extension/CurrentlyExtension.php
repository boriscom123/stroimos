<?php
namespace AppBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class CurrentlyExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('currently')) {
            $form->add('currently', 'ckeditor', array(
                'label' => 'На данный момент',
                'required' => false,
                'config_name' => 'currently',
            ));
        }
    }
}