<?php
namespace AppBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class PanoramaExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('panorama')) {
            $form->add('panorama', null, [
                'required' => false,
            ]);
        }
    }
}
