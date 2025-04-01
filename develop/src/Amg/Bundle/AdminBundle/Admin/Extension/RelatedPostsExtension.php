<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class RelatedPostsExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('relatedPosts')) {
            $form->add('relatedPosts', 'sonata_type_model_autocomplete', array(
                'label' => 'Публикации',
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false
            ));
        }
    }
}
