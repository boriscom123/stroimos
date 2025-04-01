<?php

namespace AppBundle\Admin\EmbeddedContent;

use AppBundle\Entity\EmbeddedContent\Quote;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class QuoteAdmin extends BaseEmbeddedContentAdmin
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
            ->add('text', null, ['required' => true, 'attr' => ['style' => 'height: 300px']])
            ->add('person', null)
            ->end()
            ->with('Параметры')
            ->add('publishable', null, ['required' => false])
            ->add('pages', 'collection_list', ['class' => Quote::class])
            ->end()
            ->end();
    }
}
