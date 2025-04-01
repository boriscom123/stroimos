<?php
namespace AppBundle\Admin;

use AppBundle\Entity\LawDocument;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class LawDocumentAdmin extends DecisionDocumentAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        parent::configureFormFields($form);
        $form
            ->tab('Основное')
                ->with('Параметры')
                    ->add('outgoingAgency', null, array('label' => 'Исходящий орган', 'required' => true))
                    ->add('rubrics', null, array('label' => 'Рубрика'))
                    ->add('type', 'choice', array(
                        'label' => 'Тип',
                        'required'=> false,
                        'choices' => LawDocument::$types
                    ))
                ->end()
            ->end()
        ;
    }
}
