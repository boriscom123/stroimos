<?php

namespace AppBundle\Admin\Newsletter;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class HighlightNewsletterAdmin extends Admin
{
    /**
     * @inheritdoc
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('teaser');
    }

    /**
     * @inheritdoc
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->addIdentifier('teaser');
    }

    /**
     * @inheritdoc
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form->tab('Основное')
            ->with('Контент')
            ->add('title', null, ['required' => false, 'label' => 'Подпись изображения'])
            ->add(
                'image',
                'sonata_type_model_list',
                ['required' => true],
                ['link_parameters' => ['lock_context' => ['main_image', 'gallery_media']]]
            )
            ->add('teaser', null, ['required' => true, 'label' => 'Главный текст'])
            ->add('content', null, ['required' => false, 'attr' => ['style' => 'height: 300px']])
            ->add('link', null, ['required' => true, 'label' => 'Ссылка'])
            ->end()
            ->end();
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $rootAliases = $query->getRootAliases();
        $rootAlias = reset($rootAliases);

        $query->addOrderBy($rootAlias.'.id', 'DESC');

        return $query;
    }

}
