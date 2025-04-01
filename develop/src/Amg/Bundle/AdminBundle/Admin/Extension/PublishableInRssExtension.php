<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class PublishableInRssExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('publishableInRss')) {
            $form->add('publishableInRss', 'checkbox', array(
                'required' => false,
                'label_attr' => array('style' => 'float: left; padding-right: 0.8em;'),
            ));
        }
    }
}
