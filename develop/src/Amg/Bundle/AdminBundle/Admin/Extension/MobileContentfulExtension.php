<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class MobileContentfulExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('mobileContent')) {
            $form->add('mobileContent', 'ckeditor', [
                'config' => array(
                    'resize_minWidth' => '345px',
                    'contentsCss' => array('/css/admin/ckeditor.css', '/css/admin/mobile-content.css')
                ),
                'required' => false,
                'attr'=> ['class' => 'mobile-content-field collapsible-field']
            ]);
        }
    }
}
