<?php

namespace AppBundle\Admin\EmbeddedContent\Faq;

use AppBundle\Admin\EmbeddedContent\BaseEmbeddedContentAdmin;
use AppBundle\Entity\EmbeddedContent\Faq\FaqBlock;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class FaqBlockAdmin extends BaseEmbeddedContentAdmin
{
    /**
     * @inheritdoc
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')
            ->add('publishable')
            ->add('createdAt')
            ->add('updatedAt');
    }

    /**
     * @inheritdoc
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form->tab('Основное')
            ->with('Контент')
            ->add('code',null, ['required' => true])
            ->add('text', 'ckeditor', ['required' => true, 'attr' => ['style' => 'height: 300px']])
            ->add(
                'tags',
                'sonata_type_model_autocomplete',
                array(
                    'required' => false,
                    'property' => 'title',
                    'multiple' => true,
                    'attr' => array('style' => 'width: 100%'),
                )
            )
            ->end()
            ->with('Параметры')
            ->add('publishable', null, ['required' => false])
            ->add('pages', 'collection_list', ['class' => FaqBlock::class])
            ->end()
            ->end();

        $form->tab('Вопросы и ответы')
            ->with('Вопросы и ответы')
            ->add(
                'questionsAndAnswers',
                'sonata_type_collection',
                [
                    'required' => false,
                    'by_reference' => false,
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table',
                ]
            )
            ->end()
            ->end();
    }
}
