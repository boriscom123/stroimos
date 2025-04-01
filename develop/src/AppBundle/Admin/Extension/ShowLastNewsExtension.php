<?php
namespace AppBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class ShowLastNewsExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        $form->add('showLastNews', 'checkbox', array(
            'required' => false,
            'label' => 'Отображать последние новости',
        ));
        $form->add('lastNewsTags', 'sonata_type_model_autocomplete', array(
            'required' => false,
            'property' => 'title',
            'multiple' => true,
            'attr' => array('style' => 'width: 100%'),
            'label' => 'Теги для последних новостей',
        ));
    }
}