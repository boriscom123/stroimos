<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class MetadataExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('metaDescription')) {
            $form->add('metaDescription', 'textarea', array('required' => false));
        }

        if (!$form->has('metaKeywords')) {
            $form->add('metaKeywords', 'text', array('required' => false));
        }
    }
}
