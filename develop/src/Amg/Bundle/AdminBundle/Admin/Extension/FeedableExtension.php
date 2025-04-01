<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class FeedableExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        /*if (!$form->has('feedable')) {
            $form->add('feedable', 'checkbox', array(
                'required' => false,
                'label' => 'Показывать в фиде',
                'label_attr' => array('style' => 'float: left; padding-right: 0.8em;'),
            ));
        }*/
    }
}
