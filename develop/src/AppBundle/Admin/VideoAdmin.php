<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class VideoAdmin extends BaseAdmin
{
    use PreBatchActionTrait;

    public $supportsPreviewMode = true;

    protected $datagridValues = [
        '_sort_by' => 'createdAt',
        '_sort_order' => 'DESC',
    ];

    protected function configureDatagridFilters(DatagridMapper $dataMapper)
    {
        $dataMapper
            ->add('title')
            ->add('publishable')
            ->add('isVisibleInVideoCategory', null, ['label' => 'Скрыт из раздела видео'])
            ->add('source')
            ->add('publishStartDate')
            ->add('publishEndDate')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('author')
        ;

        $this->addOwnerDatagridFilter($dataMapper);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('publishable')
            ->add('publishStartDate')
            ->add('source')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('isVisibleInVideoCategory', 'boolean', ['label' => 'Скрыто из раздела видео'])
            ->add(
                'videoLink',
                'videoLink',
                ['template' => ':Admin:Video/list_field_video_link.html.twig']
            )
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Основное')
                ->with('Параметры')
                    ->add('isCommentsOpen', null, ['label' => 'Разрешить комментирование', 'required' => false])
                    ->add('isVisibleInVideoCategory', 'checkbox', ['label' => 'Скрыт из раздела Видео', 'required' => false])
            ->end()
            ->end()
        ;

        $form->add('video', 'sonata_type_model_list', [], ['link_parameters' => ['context' => 'video', 'lock_context' => true]]);
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        if ($this->hasRoute('edit') && $this->isGranted('EDIT')) {
            $actions['invisibleVideo'] = [
                'label' => 'Скрыть из раздела видео',
                'ask_confirmation' => true, // by default always true
            ];

            $actions['visibleVideo'] = [
                'label' => 'Показать в разделе видео',
                'ask_confirmation' => true, // by default always true
            ];
        }

        return $actions;
    }
}
