<?php
namespace Amg\Bundle\TagBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class TagsExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        //todo: disabled extra features
//        if ('ExtraBundle\Entity\Initiative' === $form->getAdmin()->getClass()) {
//            return;
//        }

        if (!$form->has('tags')) {
            $form->add('tags', 'sonata_type_model_autocomplete', array(
                'required' => false,
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
            ));
        }
    }
}
