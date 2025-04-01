<?php

namespace AppBundle\Admin\EmbeddedContent;

use AppBundle\Entity\Page;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BannerAdmin extends BaseEmbeddedContentAdmin
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
            ->add('publishable', null, ['required' => false])
            ->end()
            ->with('Параметры')
            ->add('link', null, ['label' => 'Ссылка', 'required' => false])
            ->add('isTargetBlank', null, ['required' => false])
            ->add('image', 'sonata_type_model_list', ['required' => false], ['link_parameters' => ['lock_context' => ['main_image', 'gallery_media']]])
            ->add('pages', 'collection_list', ['class' => Page::class])
            ->end()
            ->end();
    }
}
