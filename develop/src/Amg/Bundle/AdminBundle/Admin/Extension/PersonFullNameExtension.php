<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class PersonFullNameExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('lastName')) {
            $form->add('lastName', null);
        }
        if (!$form->has('firstName')) {
            $form->add('firstName', null);
        }
        if (!$form->has('patronymic')) {
            $form->add('patronymic', null, ['required' => false]);
        }
    }
}
