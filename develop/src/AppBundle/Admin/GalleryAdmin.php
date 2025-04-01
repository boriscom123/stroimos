<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Gallery;
use AppBundle\Entity\GalleryMedia;
use AppBundle\Entity\MediaCategory;
use Application\Sonata\MediaBundle\Entity\Media;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GalleryAdmin extends BaseAdmin
{
    use PreBatchActionTrait;

    public $supportsPreviewMode = true;

    protected $datagridValues = [
        '_sort_by' => 'createdAt',
        '_sort_order' => 'DESC',
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('publishable')
            ->add('hiddenFromGallery')
            ->add('publishStartDate')
            ->add('publishEndDate')
            ->add('createdAt')
            ->add('updatedAt')
        ;

        $this->addOwnerDatagridFilter($datagridMapper);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('publishable')
            ->add('hiddenFromGallery')
            ->add('publishStartDate')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Основное')
                ->with('Контент')
                    ->add(
                        'animatedWallpaper',
                        'gif_generator',
                        [
                            'required' => false,
                            'imagesSelector' => "div[role='image-container'] img",
                            'mediaIdsSelector' => "div[role='image-container'] input.image",
                        ],
                        [
                            'label' => 'Тест',
                            'link_parameters' => ['lock_context' => ['main_image']],
                        ]
                    )
                ->end()
                ->with('Параметры')
                    ->add('hiddenFromGallery', 'checkbox', ['required' => false])
                ->end()
            ->end()
            ->add('medias', 'media_collection', array(
                'label' => false,
                'required' => false
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable'  => 'position',
            ))
            ->add('batch_upload', 'file', array(
                'mapped' => false,
                'required' => false,
                'label' => 'Пакетная загрузка',
                'multiple' => true,
            ))
            ->add('copyright', 'text', array(
                'mapped' => false,
                'required' => false,
                'label' => 'Копирайт',
            ))
            ->add('batch_category', 'media_category_tree', array(
                'mapped' => false,
                'class' => 'AppBundle:MediaCategory',
                'required' => false,
                'label' => 'Родительская категория'
            ))
            ->add('batch_create_category', 'text', array(
                'mapped' => false,
                'required' => false,
                'label' => 'Создать категорию в выбранной',
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('teaser')
            ->add('metaDescription')
            ->add('metaKeywords')
            ->add('publishable')
            ->add('hiddenFromGallery')
            ->add('publishStartDate')
            ->add('publishEndDate')
            ->add('feedable')
            ->add('publishableInRss')
            ->add('searchable')
            ->add('relevantNewsShown')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('deletedBy')
        ;
    }

    /**
     * @param Gallery $object
     * @return void
     */
    public function prePersist($object)
    {
        $this->save($object);
    }

    /**
     * @param Gallery $object
     * @return void
     */
    public function preUpdate($object)
    {
        $this->save($object);
    }

    /**
     * {@inheritdoc}
     */
    public function getPersistentParameters()
    {
        return array_merge(parent::getPersistentParameters(), array(
            'CKEditorFuncNum' => 'gallery'
        ));
    }


    /**
     * @param Gallery $object
     * @return void
     */
    private function save($object)
    {
        $batchUpload = $this->getForm()->get('batch_upload')->getData();
        $category = $this->getForm()->get('batch_category')->getData();
        $copyright = $this->getForm()->get('copyright')->getData();

        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');

        if ($createCategory = $this->getForm()->get('batch_create_category')->getData()) {
            $newCategory = new MediaCategory();
            $newCategory->setTitle($createCategory);
            $newCategory->setParent($category);
            $category = $newCategory;
        }

        foreach ($batchUpload as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $media = new Media();

            $media->setBinaryContent($file);
            $media->setProviderName('sonata.media.provider.image');
            $media->setContext('gallery_media');
            $media->setEnabled(true);
            $media->setCategory($category);
            $media->setCopyright($copyright);

            $em->persist($category);
            $em->persist($media);

            $galleryMedia = new GalleryMedia();
            $galleryMedia->setImage($media);

            $em->persist($galleryMedia);

            $object->addMedia($galleryMedia);
        }

        foreach($object->getMedias() as $media) {
            $media->setGallery($object);
        }
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('browse');
    }
}
