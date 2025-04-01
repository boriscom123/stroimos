<?php

namespace AppBundle\Admin;

use AppBundle\Admin\Form\PrivateUrlTrait;
use AppBundle\Constraints\UniqueCollectionConstraint;
use AppBundle\Entity\Construction;
use AppBundle\Entity\Embeddable\ConstructionData;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\Translation\TranslatorInterface;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ConstructionAdmin extends Admin
{
    use PrivateUrlTrait;

    const TAB_TITLE = 'Характеристики';
    const GROUP_TITLE__API = 'Характеристики из внешних источников';
    const GROUP_TITLE__OTHERS = 'Прочие характеристики';

    const FILTER_BY_IMPORT_VALUE_ONLY_NEW = 'only new';
    const FILTER_BY_IMPORT_VALUE_ONLY_UPDATED = 'only updated';

    protected $datagridValues = [
        '_sort_by' => 'updatedAt',
        '_sort_order' => 'DESC',
    ];

    public $supportsPreviewMode = true;

    public function __construct($code, $class, $baseControllerName, TranslatorInterface $translator)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->setTranslator($translator);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $constructionTypeRepository = $modelManager->getEntityManager('AppBundle:ConstructionType')->getRepository('AppBundle:ConstructionType');
        $constructionRepository = $modelManager->getEntityManager('AppBundle:Construction')->getRepository('AppBundle:Construction');

        $endYearCollection = $constructionRepository->findAvailableEndYearCollection();
        $startYearCollection = $constructionRepository->findAvailableStartYearCollection();

        $datagridMapper
            ->add('publishable')
            ->add('objectName', null, ['label' => 'form.label_title'])
            ->add('startYear', 'doctrine_orm_callback', [
                'label' => 'form.label_construction_start_year',
                'callback' => [$this, 'applyFilterByStartYear'],
                'field_type' => 'choice',
                'field_options' => [
                    'choices' => array_combine($startYearCollection, $startYearCollection),
                ],
            ])
            ->add('endYear', 'doctrine_orm_callback', [
                'label' => 'form.label_construction_end_year',
                'callback' => [$this, 'applyFilterByEndYear'],
                'field_type' => 'choice',
                'field_options' => [
                    'choices' => array_combine($endYearCollection, $endYearCollection),
                ],
            ])
            ->add('objectAddress' , null, ['label' => 'form.label_address'])
            ->add('customDataObjectStatus', 'doctrine_orm_callback', [
                'callback' => [$this, 'applyFilterByObjectStatus'],
                'field_type' => 'choice',
                'field_options' => [
                    'choices' => ConstructionStatus::$labels,
                ]
            ])
            ->add('customDataMainFunctional', 'doctrine_orm_callback', [
                'callback' => [$this, 'applyFilterByMainFunctional'],
                'field_type' => 'choice',
                'label' => 'soap_data.MainFunctional',
                'field_options' => [
                    'choices' => $constructionTypeRepository->getSelectOptions(),
                ]
            ])
            ->add('areCoordinatesSet', 'doctrine_orm_callback', [
                'callback' => [$this, 'applyAreCoordinatesSet'],
                'field_type' => 'choice',
                'field_options' => [
                    'choices' => [
                        'are_set' => 'Установлены',
                        'are_not_set' => 'Не установлены'
                    ],
                ]
            ])
            ->add('areUgdIdsSet', 'doctrine_orm_callback', [
                'callback' => [$this, 'applyAreareUgdIdSet'],
                'label' => 'Наличие objectId',
                'field_type' => 'choice',
                'field_options' => [
                    'choices' => [
                        'are_set' => 'Установлены',
                        'are_not_set' => 'Не установлены'
                    ],
                ]
            ])
            ->add('areUniqueIdsSet', 'doctrine_orm_callback', [
                'callback' => [$this, 'applyAreUniqueIdSet'],
                'label' => 'Наличие UniqueId',
                'field_type' => 'choice',
                'field_options' => [
                    'choices' => [
                        'are_set' => 'Установлены',
                        'are_not_set' => 'Не установлены'
                    ],
                ]
            ])
            ->add('filter_by_import', 'doctrine_orm_callback', [
                'callback' => [$this, 'applyFilterByImport'],
                'field_type' => 'choice',
                'field_options' => [
                    'choices' => [
                        null => 'Без фильтра',
                        static::FILTER_BY_IMPORT_VALUE_ONLY_NEW => $this->translator->trans('admin.construction.onlyNew'),
                        static::FILTER_BY_IMPORT_VALUE_ONLY_UPDATED => $this->translator->trans('admin.construction.onlyUpdated'),
                    ],
                ]
            ])
        ;
    }

    /**
     * @param ProxyQuery|QueryBuilder $qb
     */
    public function applyFilterByStartYear(ProxyQuery $qb, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }
        /** @var QueryBuilder $qb */
        $qb->andWhere(
            $qb->expr()->eq("{$alias}.startYear", $value['value'])
        );

        return true;
    }

    /**
     * @param ProxyQuery|QueryBuilder $qb
     */
    public function applyFilterByEndYear(ProxyQuery $qb, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }
        /** @var QueryBuilder $qb */
        $qb->andWhere(
            $qb->expr()->eq("{$alias}.endYear", $value['value'])
        );

        return true;
    }

    public function applyAreCoordinatesSet(ProxyQuery $qb, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }
        /** @var QueryBuilder $qb */
        if ($value['value'] === 'are_set') {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->isNotNull("{$alias}.data.PointXyGeometryCoordinates"),
                    $qb->expr()->isNotNull("{$alias}.customData.PointXyGeometryCoordinates")
                )
            );
        }
        else {
            $qb->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->isNull("{$alias}.data.PointXyGeometryCoordinates"),
                    $qb->expr()->isNull("{$alias}.customData.PointXyGeometryCoordinates")
                )
            );

        }

        return true;
    }
    public function applyAreareUgdIdSet(ProxyQuery $qb, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }
        /** @var QueryBuilder $qb */
        if ($value['value'] === 'are_set') {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->isNotNull("{$alias}.objectId")
                )
            );
        }
        else {
            $qb->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->isNull("{$alias}.objectId")
                )
            );

        }

        return true;
    }
    public function applyAreUniqueIdSet(ProxyQuery $qb, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }
        /** @var QueryBuilder $qb */
        if ($value['value'] === 'are_set') {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->isNotNull("{$alias}.uniqueId")
                )
            );
        }
        else {
            $qb->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->isNull("{$alias}.uniqueId")
                )
            );

        }

        return true;
    }
    /**
     * @param ProxyQuery $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function applyFilterByObjectStatus(ProxyQuery $qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }
        /** @var QueryBuilder $qb */
        $qb->andWhere(
            $qb->expr()->eq("{$alias}.customData.ObjectStatus", "'{$value['value']}'")
        );

        return true;
    }


    public function applyFilterByMainFunctional(ProxyQuery $qb, $alias, $field, $value)
    {
        if ($value['value'] === null) {
            return;
        }
        /** @var QueryBuilder $qb */
        $qb->andWhere(
            $qb->expr()->eq("{$alias}.customData.MainFunctional", "'{$value['value']}'")
        );

        return true;
    }
    public function applyFilterByImport(ProxyQuery $qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return false;
        }

        if ($value['value'] === static::FILTER_BY_IMPORT_VALUE_ONLY_NEW) {

            $qb->andWhere(
                $qb->expr()->eq("{$alias}.new", 1)
            );

            return true;
        }

        $qb->andWhere(
            $qb->expr()->eq("{$alias}.updated", 1)
        );

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('title', null, ['template' => ':ConstructionAdmin:CRUD/title.html.twig', 'header_style' => 'width: 35%'])
            ->add('address')
            ->add('objectId', null, ['label' => 'objectId'])
            ->add('uniqueId', 'text', ['label' => 'uniqueId'])
            ->add('ObjectUpdateDateTime',  'datetime', ['sortable' => false, 'label' => 'Последнее обновление в шине'])
            ->add('updatedAt')
            ->add('createdAt')
            ->add('publishable', null, ['editable' => true])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Основное')
                ->with('Контент')
                    //TODO remove teaser from entity
                    ->add(
                        'teaser',
                        'textarea',
                        ['required' => false, 'read_only' => true, 'label' => 'Старое описание (будет удалено)']
                    )
                    ->add('content', 'ckeditor', array('required' => false, 'label' => 'Описание'))
                    ->add(
                        'organization',
                        'sonata_type_model_list',
                        [
                            'label' => 'Организация (Застройщик)',
                            'required' => false,
                            'btn_add' => false
                        ]
                    )
                ->end()
            ->end();

        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $constructionTypeRepository = $modelManager->getEntityManager('AppBundle:ConstructionType')->getRepository('AppBundle:ConstructionType');


        $property = 'ObjectStatus';
        $formMapper->tab(self::TAB_TITLE)->with(self::GROUP_TITLE__API, ['translation_domain' => 'soap'])
            ->add("customData$property", 'construction_data_choice', [
                'placeholder' => 'Выберите статус объекта',
                'data_property_name' => $property,
                'property_path' => "customData.$property",
                'required' => true,
                'label' => $property,
                'choices' => ConstructionStatus::$labels,
            ])
            ->end()
            ->end();

        $property = 'MainFunctional';
        $formMapper->tab(self::TAB_TITLE)->with(self::GROUP_TITLE__API, ['translation_domain' => 'soap'])
            ->add("customData$property", 'construction_data_choice', [
                'data_property_name' => $property,
                'property_path' => "customData.$property",
                'required' => true,
                'label' => $property,
                'choices' => $constructionTypeRepository->getSelectOptions(),
                'placeholder' => ''
            ])
            ->end()
            ->end();

        $property = 'MainFunctionalCode';
        $formMapper->tab(self::TAB_TITLE)->with(self::GROUP_TITLE__API, ['translation_domain' => 'soap'])
            ->add("customData$property", 'construction_data_text', [
                'data_property_name' => $property,
                'property_path' => "customData.$property",
                'required' => false,
                'label' => $property,
            ])
            ->end()
            ->end();

        $customFormTypeProperties = [
            'MainFunctional',
            'ObjectStatus',
            'PointXyGeometryCoordinates',
            'LandGeometryCoordinates',
        ];
        $properties = array_diff(ConstructionData::$versionedProperties, $customFormTypeProperties);

        foreach ($properties as $property) {
            $formMapper->tab(self::TAB_TITLE)->with(self::GROUP_TITLE__API, ['translation_domain' => 'soap'])
                ->add("customData$property", 'construction_data_text', [
                    'data_property_name' => $property,
                    'property_path' => "customData.$property",
                    'required' => false,
                    'label' => $property,
                ])
                ->end()
                ->end();
        }

        $property = 'ObjectPolygon';
        $formMapper->tab(self::TAB_TITLE)->with(self::GROUP_TITLE__API, ['translation_domain' => 'soap'])
            ->add("customData$property", 'construction_data_text', [
                'data_property_name' => $property,
                'property_path' => "customData.$property",
                'required' => false,
                'label' => $property,
            ])
            ->end()
            ->end();

        $property = 'PointXyGeometryCoordinates';
        $formMapper->tab(self::TAB_TITLE)->with(self::GROUP_TITLE__API, ['translation_domain' => 'soap'])
            ->add("customData$property", 'construction_data_geo_point', [
                'data_property_name' => $property,
                'property_path' => "customData.$property",
                'required' => true,
                'label' => $property,
            ])
            ->end()
            ->end();

        $property = 'LandGeometryCoordinates';
        $formMapper->tab(self::TAB_TITLE)->with(self::GROUP_TITLE__API, ['translation_domain' => 'soap'])
            ->add("customData$property", 'construction_data_geo_polygon', [
                'data_property_name' => $property,
                'property_path' => "customData.$property",
                'required' => false,
                'label' => $property,
            ])
            ->end()
            ->end();

        $formMapper->tab(self::TAB_TITLE)->with(self::GROUP_TITLE__OTHERS)
            ->add('uniqueId', 'text', ['disabled' => true, 'label' => 'Уникальный ID новый'])
            ->add('objectId', null, ['disabled' => true, 'label' => 'Уникальный ID старый'])
            ->add('planDateStart', 'sonata_type_datetime_picker', ['disabled' => true, 'label' => 'Плановая дата начала строительства', 'format' => 'dd-MM-yyyy','required' => false])
            ->add('factDateStart', 'sonata_type_datetime_picker', ['disabled' => true, 'label' => 'Фактическая дата начала строительства', 'format' => 'dd-MM-yyyy','required' => false])
            ->add('planDateEnd', 'sonata_type_datetime_picker', ['disabled' => true, 'label' => 'Плановая дата завершения строительства', 'format' => 'dd-MM-yyyy','required' => false])
            ->add('factDateEnd', 'sonata_type_datetime_picker', ['disabled' => true, 'label' => 'Фактическая дата завершения строительства', 'format' => 'dd-MM-yyyy','required' => false])
            ->add('planDateInput', 'sonata_type_datetime_picker', ['disabled' => true, 'label' => 'Плановая дата ввода в эксплуатацию', 'format' => 'dd-MM-yyyy','required' => false])
            ->add('factDateInput', 'sonata_type_datetime_picker', ['disabled' => true, 'label' => 'Фактическая дата ввода в эксплуатацию', 'format' => 'dd-MM-yyyy','required' => false])
            ->add('startYear', null, ['label' => 'Год начала строительства', 'required' => false])
            ->add('endYear', null, ['label' => 'Год окончания строительства (Срок ввода)', 'required' => false])
            ->add('areaOfTheTerritory', null, ['required' => false])
            ->add('roominess', null, ['required' => false])
            ->add('numberOfParkingPlaces', null, ['required' => false])
            ->add('projectSeries', null, ['required' => false])
            ->add('projectDesigner', null, ['required' => false])
            ->add('constructionParameterValues', 'sonata_type_collection', [
                'required'     => false,
                'by_reference' => false,
                'constraints' => [
                    new UniqueCollectionConstraint([
                        'collectionName' => 'Значения характеристик',
                        'field' => 'constructionParameter.id'
                    ])
                ]
            ], [
                'edit'=> 'inline',
                'inline' => 'table'
            ])
            ->end()
            ->end();

        $formMapper->tab('Основное')->with('Параметры')
            ->add('new', 'checkbox', array('value' => false, 'required' => false, 'label' => 'Новый', 'label_attr' => array('style' => 'float: left; padding-right: 0.8em;')))
            ->add('updated', 'checkbox', array('value' => false, 'required' => false, 'label' => 'Обновленный', 'label_attr' => array('style' => 'float: left; padding-right: 0.8em;')));
        $this->addPrivateUrl($this, $formMapper);
        $formMapper->end()->end();
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }

    /**
     * @inheritdoc
     */
    public function preUpdate($object)
    {
        /** @var Construction $object */
        $coordinates = explode(',', $object->getData()->getPointXyGeometryCoordinates());
        $customCoordinates = $object->getCustomData()->getPointXyGeometryCoordinates();

        if ($customCoordinates !== null) {
            $object->setPoint(new Point($customCoordinates->getLongitude(), $customCoordinates->getLatitude()));
        } elseif (count($coordinates) === 2 && !empty($coordinates[0]) && !empty($coordinates[1])) {
            $object->setPoint(new Point($coordinates[0], $coordinates[1]));
        }

        parent::preUpdate($object);
    }

    /**
     * {@inheritdoc}
     */
    public function update($object)
    {
        try {
            return parent::update($object);
        } catch (ModelManagerException $e) {
            $this->configurationPool->getContainer()->get('session')
                ->getFlashBag()
                ->add('error', $e->getPrevious());
            throw $e;
        }
    }

    public function configure() {
        $this->setTemplate('edit', ':Admin:Construction/edit.html.twig');
    }
}
