<?php
namespace AppBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class CategorizedExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('category')) {
            $form->add('category', 'entity', array(
                'class' => 'AppBundle\Entity\Category',
            ));
        }
    }
}
