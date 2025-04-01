<?php

namespace AppBundle\Admin;

use AppBundle\Admin\Form\PrivateUrlTrait;
use AppBundle\Entity\AdministrativeArea;
use AppBundle\Entity\Category;
use AppBundle\Entity\CityDistrict;
use AppBundle\Entity\Construction;
use AppBundle\Entity\Post;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class PostAdmin extends AdminWithNotifications
{
    use PreBatchActionTrait, PrivateUrlTrait;

    public $supportsPreviewMode = true;
    protected $formOptions = array(
        'cascade_validation' => true,
    );
    protected $datagridValues = [
        '_sort_by' => 'publishStartDate',
        '_sort_order' => 'DESC',
    ];

    /** @var  EntityRepository */
    private $categoryRepository;

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $categoryAlias = $this->getPersistentParameter('category_alias');

        if ('trash' === $categoryAlias) {
            $this
                ->getModelManager()
                ->getEntityManager($this->getClass())
                ->getFilters()
                    ->disable('not_moved_to_trash')
            ;

            $query->andWhere('o.deletedAt is not null');
            return $query;
        }
        /** @var $query QueryBuilder */
        if ($categoryAlias) {
            $query->innerJoin('o.category', 'c')
                ->andWhere('c.alias  = :alias')
                ->setParameter(':alias', $categoryAlias)
            ;

            return $query;
        }
        if ($this->getUserOwner() !== null) {
            $query->innerJoin('o.category', 'c')
                ->andWhere('c.alias IN (:allowedAliases)')
                ->setParameter('allowedAliases', $this->getUserOwnerAllowedAliases());
        }

        return $query;
    }

    public function getUserOwnerAllowedAliases()
    {
        return [
            Category::CATEGORY_INTERVIEW,
            Category::CATEGORY_PRESS_RELEASE,
            Category::CATEGORY_ARTICLE,
            Category::CATEGORY_SHORTHAND_REPORTS,
        ];
    }

    /**
     * @param mixed $categoryRepository
     */
    public function setCategoryRepository($categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function prePersist($object)
    {
        $this->linkRelatedEntities($object);
        $this->addRelatedConstructions($object);
    }

    protected function linkRelatedEntities(Post $post)
    {
        foreach ($post->getAttachments() as $attachment) {
            $attachment->setPost($post);
        }
    }

    private function addRelatedConstructions(Post $post)
    {
        foreach ($this->getConstructionsFromContent($post->getContent()) as $construction) {
            $post->addRelatedConstructions($construction);
        }
    }

    private function getConstructionsFromContent($content)
    {
        if (preg_match_all('~/construction/(\d+)~', $content, $matches)) {
            foreach ($matches[1] as $constructionId) {
                if ($construction = $this->getModelManager()->find(Construction::class, $constructionId)) {
                    yield $construction;
                }
            }
        }
    }

    public function preUpdate($object)
    {
        $this->linkRelatedEntities($object);
        $this->addRelatedConstructions($object);
    }

    /**
     * @return array|mixed|null
     * @internal param string $name
     */
    public function getPersistentParameters()
    {
        $parameters = parent::getPersistentParameters();

        if ($this->hasRequest()) {
            $parameters['category_alias'] = $this->getRequest()->get('category_alias');
        }

        return $parameters;
    }

    public function getTopMenuItems()
    {
        if ($this->getUserOwner()) {
            return $this->categoryRepository->findBy(
                ['alias' => $this->getUserOwnerAllowedAliases()],
                ['title' => 'ASC']
            );
        } else {
            $categories = $this->categoryRepository->findBy(array(), array('title' => 'ASC'));
            $categories[] = (new Category())
                ->setAlias('trash')
                ->setTitle('Корзина')
            ;
            return $categories;
        }
    }

    public function getNewInstance()
    {
        /** @var Post $post */
        $post = parent::getNewInstance();

        if (null === $this->getPersistentParameter('category_alias')) {
            return $post;
        }

        /** @var ObjectRepository $repository */
        $repository = $this->configurationPool
            ->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Category')
        ;
        $alias = $this->getPersistentParameter('category_alias');
        $post->setCategory($repository->findOneBy(['alias' => $alias]));

        return $post;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('author')
            ->add('source')
            ->add('journalistWriter')
            ->add('editor')
            ->add('publishable')
            ->add('createdAt', 'date_range_filter', ['label' => 'Дата создания'], 'date_range')
            ->add('publishStartDate', 'date_range_filter', ['label' => 'Дата начала публикации'], 'date_range')
            ->add('publishEndDate', 'date_range_filter', ['label' => 'Дата окончания публикации'], 'date_range');

        $isNews = 'news' === $this->getPersistentParameter('category_alias');
        if ($isNews) {
            $datagridMapper
                ->add('inTop')
                ->add('isAssociatedWithAdmUnit', 'doctrine_orm_callback', [
                    'callback' => [$this, 'applyIsAssociatedWithAdmUnit'],
                    'field_type' => 'choice',
                    'field_options' => [
                        'choices' => [
                            'is_associated' => 'присутствует ',
                            'is_not_associated' => 'отсутсвует'
                        ],
                    ]
                ])
            ;

        }

        $this->addOwnerDatagridFilter($datagridMapper);
    }

    public function applyIsAssociatedWithAdmUnit(ProxyQuery $qb, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }
        /** @var QueryBuilder $qb */
        $qb->leftJoin("{$alias}.administrativeAreas", "adminArea", Expr\Join::WITH);
        $qb->leftJoin("{$alias}.cityDistricts", "cityDistrict", Expr\Join::WITH);

        if ($value['value'] === 'is_associated') {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->isNotNull("adminArea.id"),
                    $qb->expr()->isNotNull("cityDistrict.id")
                )
            );
        }
        else {
            $qb->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->isNull("adminArea.id"),
                    $qb->expr()->isNull("cityDistrict.id")
                )
            );
        }

        return true;
    }
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $categoryAlias = $this->getPersistentParameter('category_alias');

        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('publishable', null, array('editable' => true));

        $isPriorityColVisible = $categoryAlias === Category::CATEGORY_NEWS
            && (
                $user->hasGroup('Главный редактор')
                || $user->hasGroup('Администраторы')
                || $user->hasRole('ROLE_SUPER_ADMIN')
            );

        if ($isPriorityColVisible) {
            $listMapper->add(
                'priorityPosition',
                'priority-position',
                ['template' => ':Admin:Post/list_field_priority_position.html.twig']
            );
        }

        $listMapper
            ->add('publishStartDate')
            ->add('createdAt')
            ->add('updatedAt');

        $actions = [
            self::NOTIFICATION_ACTION_NAME => ['template' => self::NOTIFICATION_ACTION_TEMPLATE],
        ];

        if (Category::CATEGORY_NEWS == $categoryAlias) {
            $actions['toggleInTop'] = ['template' => ':Admin:Post/list__action_toggle_in_top.html.twig'];
        }

        $listMapper->add(
            '_action',
            'actions',
            [
                'label' => 'Действия',
                'actions' => $actions,
            ]
        );
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->tab('Основное')->with('Параметры');

        if ($this->isCategoryNews()) {
            //$form->add('inTop', null, ['label' => 'В топе новостей', 'required' => false]);
        }
        $form
            ->add('forRss', null, ['required' => false])
            ->add('forYaZenRss', null, ['required' => false]);
            //->add('wordIsSmallRss', null, ['required' => false]);

        $this->addPrivateUrl($this, $form);

        $form
            ->end()
            ->end();

        $form
            ->add('editor', 'sonata_type_model_list', array('required' => false))
            ->add('journalistWriter', 'sonata_type_model_list', array('required' => false))
            ->end()
            ->end();

        $form->tab('Адресная информация')->with('Адрес');

        $form->add(
            'administrativeAreas',
            'sonata_type_model',
            [
                'label' => 'Административный округ',
                'required' => false,
                'property' => 'displayTitle',
                'class' => AdministrativeArea::class,
                'multiple' => true,
            ]
        );

        $em = $this->modelManager->getEntityManager(CityDistrict::class);

        $CityDistrict = $em->createQueryBuilder('c')
            ->select('c')
            ->from('AppBundle:CityDistrict', 'c')
            ->where('c.publishable = true');

        $form->add(
            'cityDistricts',
            'sonata_type_model',
            [
                'label' => 'Район',
                'required' => false,
                'property' => 'displayTitle',
                'class' => CityDistrict::class,
                'query' => $CityDistrict,
                'multiple' => true,
            ]
        );

        $form->end()->end();

        $form->tab('RSS')->with('Контент для платформы "Мир тесен"');

        $form->add(
            'copy_content_button',
            'copy_content_button',
            [
                'label' => false,
                'required' => false,
                'mapped' => false,
                'config' => [
                    'button_title' => 'Копировать текст из основного содержимого',
                    'copy_from' => 'content',
                    'copy_to' => 'wordIsSmallContent',
                ],
            ]
        );

        $form->add(
            'wordIsSmallContent',
            'ckeditor',
            [
                'label' => 'Контент',
                'required' => false,
            ]
        );


        $form->end()->end();
    }

    /**
     * @return bool
     */
    protected function isCategoryNews()
    {
        if ($subject = $this->getSubject()) {
            return $subject->getCategory() && $subject->getCategory()->getAlias() === Category::CATEGORY_NEWS;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('publishable')
            ->add('publishStartDate')
            ->add('publishEndDate')
            ->add('priorityPosition')
            ->add('isCommentsOpen')
            ->add('category')
            ->add('title')
            ->add('teaser')
            ->add('lead')
            ->add('content');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection
            ->add('revert_revision', '{id}/history/{base_rev_id}/{compare_rev_id}/revert/{field_name}')
            ->add('toggleInTop', $this->getRouterIdParameter().'/toggleInTop')
            ->add('restore', $this->getRouterIdParameter().'/restore')
        ;
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $categoryAlias = $this->getPersistentParameter('category_alias');

        if ($categoryAlias === Category::CATEGORY_NEWS &&  $this->isGranted('EDIT')) {
            return [
                'clear_top' => [
                    'label' => $this->trans('action.clear_top'),
                    'ask_confirmation' => true, // by default always true
                ]
            ];
        }

        if ($categoryAlias === 'trash' &&  $this->isGranted('EDIT')) {
            return [
                'restore' => [
                    'label' => $this->trans('action.restore'),
                    'ask_confirmation' => true, // by default always true
                ],
                'delete' => [
                    'label' => $this->trans('action_delete', [], 'SonataAdminBundle'),
                    'ask_confirmation' => true, // by default always true
                ],
            ];
        }
        return parent::getBatchActions();
    }

    public function delete($object)
    {
        $isInTrash = $object->getDeletedAt() !== null;
        if ($isInTrash) {
            parent::delete($object);
            return;
        }

        $this->moveToTrash($object);
    }

    protected function moveToTrash($object)
    {
        $object->setDeletedAt(new \DateTime());
        $this->getModelManager()->update($object);
    }

    public function preBatchAction($actionName, ProxyQueryInterface $query, array &$idx, $allElements)
    {
        parent::preBatchAction($actionName, $query, $idx, $allElements);
    }

    public function create($object)
    {
        try {
            return parent::create($object);
        } catch (ModelManagerException $e) {
            $prevException = $e->getPrevious();
            if ($prevException instanceof UniqueConstraintViolationException) {
                $message = "Публикация с именем \"{$object->gettitle()}\" уже существует";
                $this->getConfigurationPool()->getContainer()->get('session')->getFlashBag()
                    ->add('sonata_flash_error', $message);
            }

            throw $e;
        }
    }
}
