<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class RelevantNewsShownExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('relevantNewsShown')) {
            $form->add('relevantNewsShown', 'checkbox', array(
                    'required' => false,
                    'label_attr' => array('style' => 'float: left; padding-right: 0.8em;'),
                )
            );
        }
    }
}
