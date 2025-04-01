<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class RubricsExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('rubrics')) {
            $form->add('rubrics', null, [
                'required' => false,
                'multiple' => true,
//                'expanded' => true,
            ]);
        }
    }
}
