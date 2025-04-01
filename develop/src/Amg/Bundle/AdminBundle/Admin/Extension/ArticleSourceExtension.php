<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class ArticleSourceExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('source')) {
            $form->add('source', 'sonata_type_model_list', array(
                'required' => false,
            )
            );
        }
    }
}
