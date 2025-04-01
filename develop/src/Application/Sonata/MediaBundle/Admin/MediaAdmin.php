<?php

namespace Application\Sonata\MediaBundle\Admin;

use Amg\Bundle\AdminBundle\Admin\Extension\ImageExtension;
use AppBundle\Entity\MediaCategory;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\MediaBundle\Admin\ORM\MediaAdmin as BaseMediaAdmin;

class MediaAdmin extends BaseMediaAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('edit_image_format', $this->getRouterIdParameter().'/edit-image-format', [], [])
            ->add('batch_upload', 'batch_upload');
        ;
    }
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        if (
            $this->hasRoute('edit') && $this->isGranted('EDIT')
        ) {
            $actions['copyright'] = array(
                'label' => 'Изменить копирайт',
                'ask_confirmation' => true
            );

        }

        return $actions;
    }
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        if ('gallery_media' === $this->getPersistentParameter('context')) {
            $datagridMapper
                ->add('gallery', 'doctrine_orm_callback', [
                    'label' => 'Галерея',
                    'callback' => [$this, 'getGalleryFilter'],
                    'field_type' => 'text'
                ]);
        }

        $contexts = null;
        $lock = $this->getRequest()->query->get('lock_context');
        if($lock === null) {
            $contexts = array_keys($this->getPool()->getContexts());
        } elseif ($lock === '1') {
            $context = $this->getRequest()->query->get('context');
            if($context !== null) {
                $contexts = explode(',', $context);
            }
        } elseif (is_array($lock)) {
            $contexts = $lock;
        }

        if(is_array($contexts)) {
            $contexts = array_combine($contexts, array_map([$this, 'trans'], $contexts));

            $datagridMapper
                ->add('name')
                ->add('providerReference')
                ->add('enabled')
                ->add('copyright', 'doctrine_orm_callback', [
                    'callback'      => array($this, 'getCopyrightFilter'),
                ])
                ->add('createdAt', 'doctrine_orm_date_range', [
                    'field_type'=>'sonata_type_date_range_picker',
                    'field_options' => [
                        'format' => 'dd.MM.yyyy'
                    ]
                ])
                ->add('context', 'doctrine_orm_choice', array(
                        'field_options' => array(
                            'choices'  => $contexts,
                            'required' => false,
                            'multiple' => false,
                            'expanded' => false,
                        ),
                        'field_type' => 'choice',
                    ))
            ;
        }


        $providers = array();

        $providerNames = (array) $this->pool->getProviderNamesByContext($this->getPersistentParameter('context', $this->pool->getDefaultContext()));
        foreach ($providerNames as $name) {
            $providers[$name] = $this->trans($name);
        }

        $datagridMapper->add('category');
    }

    public function getCopyrightFilter(ProxyQuery $queryBuilder, $alias, $field, $value)
    {
        if (null === $value['value']) {
            return;
        }

        if($value['value'] === '!') {
            $queryBuilder->andWhere('o.copyright IS NULL');
        }
        elseif($value['value'] === '!=') {
            $queryBuilder->andWhere('o.copyright IS NOT NULL');
        }
        else {
            $queryBuilder->andWhere('o.copyright = :copyright');
            $queryBuilder->setParameter('copyright', $value['value']);
        }
    }

    public function getGalleryFilter(ProxyQuery $queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $expr = $queryBuilder->expr();

        $likes = $expr->andX();

        $searches = preg_split('~\s+~', $value['value']);
        foreach ($searches as $searchValue) {
            $likes->add($expr->like(
                "g.title",
                $expr->literal("%{$searchValue}%")
            ));
        }

        $subQB = new QueryBuilder($queryBuilder->getEntityManager());
        $subQB
            ->select('IDENTITY(gm.image)')
            ->distinct(true)
            ->from('AppBundle:GalleryMedia', 'gm')
            ->join('gm.gallery', 'g')
            ->where($likes);

        $queryBuilder->andWhere(
            $expr->in($alias . '.id', $subQB->getDQL())
        );

        return true;
    }

    public function getMediaProvider(Media $media)
    {
        return $this->getPool()->getProvider($media->getProviderName());
    }

    public function getEditableFormats(Media $media, $formatsToEdit)
    {
        if (empty($formatsToEdit) || !is_array($formatsToEdit)) {
            return [];
        }

        $provider = $this->getMediaProvider($media);
        $formats = $provider->getFormats();

        $editableFormats = [];
        foreach ($formatsToEdit as $shortFormatName) {
            $fullFormatName = $provider->getFormatName($media, $shortFormatName);
            if (!isset($formats[$fullFormatName])) {
                throw new \RuntimeException("Media format '$fullFormatName' not found for edit.");
            }

            $mediaFormat = $formats[$fullFormatName];

            if (empty($mediaFormat['width']) || empty($mediaFormat['height']) || empty($mediaFormat['quality'])) {
                throw new \RuntimeException("To be editable '$fullFormatName' media format must have width, height and quality properties defined.");
            }

            $editableFormats[$fullFormatName] = [
                'format' => $fullFormatName,
                'short_name' => $shortFormatName,
                'reference' => $provider->getReferenceImage($media),
                'width' => $mediaFormat['width'],
                'height' => $mediaFormat['height'],
                'ratio' => $mediaFormat['width'] / $mediaFormat['height'],
                'minimum_constraints' => [$mediaFormat['width'], $mediaFormat['height']],
                'quality' => $mediaFormat['quality']
            ];
        }

        return $editableFormats;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->add('category', 'media_category_tree', array(
                'class' => MediaCategory::class,
                'required' => false,
                'label' => 'Родительская категория'
            ))
            ->add('create_category', 'text', array(
                'required' => false,
                'label' => 'Создать категорию в выбранной',
            ))
        ;
    }

    public function getPersistentParameters()
    {
        $persistentParameters = parent::getPersistentParameters();

        if ($category  = $this->getRequest()->get('category')) {
            $persistentParameters['category'] = $category;
        }

        return $persistentParameters;
    }

    public function getNewInstance()
    {
        $media = parent::getNewInstance();

        $doctrine = $this->getConfigurationPool()->getContainer()->get('doctrine');

        $category = $this->hasRequest() && $this->getRequest()->get('category')
            ? $doctrine->getRepository(MediaCategory::class)->find($this->getRequest()->get('category'))
            : $doctrine->getRepository(MediaCategory::class)->findOneBy(['root' => 1, 'lvl' => 0], ['title' => 'ASC']);

/*        $formName = $this->getUniqid();

        if ($categoryTitle = $this->getRequest()->request->get("{$formName}[create_category]", null, true)) {
            $newCategory = new MediaCategory();
            $newCategory->setTitle($categoryTitle);
            $newCategory->setParent($category);
            $category = $newCategory;

            $doctrine->getManager()->persist($category);
        }*/

        $media->setCategory($category);

        return $media;
    }

    public function createQuery($context = 'list')
    {
        /** @var ProxyQuery $query */
        $query = parent::createQuery($context);

        $provider = $this->getRequest()->query->get('provider');
        if (!empty($provider)) {
            $qb = $query->getQueryBuilder();
            $qb->andWhere('o.providerName = :providerName')
                ->setParameter('providerName', $provider);
        }

        $extraKey = $this->getRequest()->query->get(ImageExtension::IMAGE_ADMIN_EXTRA_KEY);
        if ($extraKey !== null) {
            if ($extraKey === 'thumb1440') {
                $minWidth = 1440;
                $minHeight = 454;
            } else {
                $minWidth = 589;
                $minHeight = 454;
            }
            /** @var QueryBuilder $qb */
            $qb = $query->getQueryBuilder();
            $qb->andWhere('o.width >= :minWidth')
                ->andWhere('o.height >= :minHeight')
                ->setParameter('minWidth', $minWidth)
                ->setParameter('minHeight', $minHeight);
        }

        return $query;
    }

    public function generateUrl($name, array $parameters = array(), $absolute = false)
    {
        if($this->request) {
            $extraKey = $this->request->query->get(ImageExtension::IMAGE_ADMIN_EXTRA_KEY);
            if($extraKey !== null) {
                $parameters[ImageExtension::IMAGE_ADMIN_EXTRA_KEY] = $extraKey;
            }

            if($lock = $this->request->query->get('lock_context')) {
                $parameters['lock_context'] = $lock;
            }
        }

        return parent::generateUrl($name, $parameters, $absolute);
    }


}
