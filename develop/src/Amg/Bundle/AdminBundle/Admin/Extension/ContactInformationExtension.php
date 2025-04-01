<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class ContactInformationExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('phone')) {
            $form->add('phone', null, ['required' => false]);
        }
        if (!$form->has('fax')) {
            $form->add('fax', null, ['required' => false]);
        }
        if (!$form->has('email')) {
            $form->add('email', 'email', ['required' => false]);
        }
    }
}
