<?php

namespace AppBundle\Admin\EmbeddedContent;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TextBlockAdmin extends BaseEmbeddedContentAdmin
{
    /**
     * @inheritdoc
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')
            ->add('name')
            ->add('content')
            ->add('description');
    }

    /**
     * @inheritdoc
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('content')
            ->addIdentifier('description')
            ->add('pages', null, ['template' => ':Admin:EmbeddedContent/TextBlock/list_field_usage_places.html.twig'])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureFormFields(FormMapper $form)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();

        $isAdmin = $user->hasGroup('Администраторы') || $user->hasRole('ROLE_SUPER_ADMIN');
        $isCreation = $this->getSubject() && !$this->getSubject()->getId();

        $form->tab('Основное')
            ->with('Контент')
            ->add('name', null, [
                'required' => true,
            ])
            ->add('content', null, ['required' => true, 'attr' => ['style' => 'height: 300px']])
            ->add('description', null, [
                'required' => true,
                'read_only' => !$isAdmin && !$isCreation,
                'disabled'  => !$isAdmin && !$isCreation,
            ])
            ->end()
            ->end();
    }

    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('name')
            ->add('content')
            ->add('description')
        ;
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions = array();

        if ($this->hasRoute('delete') && $this->isGranted('DELETE')) {
            $actions['delete'] = array(
                'label'            => $this->trans('action_delete', array(), 'SonataAdminBundle'),
                'ask_confirmation' => true, // by default always true
            );
        }
        return $actions;
    }
}
