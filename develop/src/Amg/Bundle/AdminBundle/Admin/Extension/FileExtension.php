<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class FileExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('file')) {
            $form->add('file', 'sonata_type_model_list', [], ['link_parameters' => ['context' => 'file', 'lock_context' => true]]);
        }
    }
}
