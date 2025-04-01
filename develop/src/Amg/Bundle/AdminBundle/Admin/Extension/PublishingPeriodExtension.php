<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class PublishingPeriodExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('publishStartDate')) {
            $form->add('publishStartDate', 'sonata_type_datetime_picker', array(
                'required' => true,
                'dp_pick_time' => true,
                'dp_language' => 'ru',
                'dp_use_seconds' => false,
                'format' => 'dd/MM/yyyy HH:mm'
            ));
        }

        if (!$form->has('publishEndDate')) {
            $form->add('publishEndDate', 'sonata_type_datetime_picker', array(
                'required' => false,
                'dp_pick_time' => true,
                'dp_language' => 'ru',
                'dp_use_seconds' => false,
                'format' => 'dd/MM/yyyy HH:mm'
            ));
        }
    }
}
