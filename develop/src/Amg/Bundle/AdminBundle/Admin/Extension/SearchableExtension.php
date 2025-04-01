<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class SearchableExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('searchable')) {
            $form->add('searchable', 'checkbox', array(
                    'required' => false,
                    'label_attr' => array('style' => 'float: left; padding-right: 0.8em;'),
                )
            );
        }
    }
}
