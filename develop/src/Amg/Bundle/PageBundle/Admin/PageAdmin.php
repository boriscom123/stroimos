<?php

namespace Amg\Bundle\PageBundle\Admin;

use Amg\Bundle\AdminBundle\Helper\RoutesListTrait;
use Amg\Bundle\PageBundle\Layout\LayoutManager;
use Amg\Bundle\PageBundle\Model\PageInterface;
use AppBundle\Admin\BaseAdmin;
use AppBundle\Admin\Form\PrivateUrlTrait;
use AppBundle\Entity\Block;
use AppBundle\Entity\Page;
use Doctrine\ORM\QueryBuilder;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class PageAdmin extends BaseAdmin
{
    use RoutesListTrait, PrivateUrlTrait;

    public $supportsPreviewMode = true;
    public $pageTemplate;

    protected $maxPerPage = 25;

    protected $maxPageLinks = 2500;
    protected $updateDefaultFilterParameters = false;

    /**
     * @var LayoutManager
     */
    protected $layoutManager;

    public function setLayoutManager(LayoutManager $layoutManager)
    {
        $this->layoutManager = $layoutManager;
    }

    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);

        $rootAliases = $query->getRootAliases();
        $rootAlias = reset($rootAliases);

        $query->orderBy($rootAlias . '.root, ' . $rootAlias . '.left', 'ASC');

        $owner = $this->getUserOwner();
        if($owner !== null) {
            $query->andWhere(sprintf('%s.owner = :owner', $rootAlias))
                ->setParameter('owner', $owner);
        }

        return $query;
    }

    public function getBatchActions()
    {
        return [];
    }

    public function hasRoute($name)
    {
        if ($name === 'delete') {
            $subject = $this->getSubject();
            if (is_object($subject) && !$subject->getChildren()->isEmpty()) {
                return false;
            }
        }

        $route = parent::hasRoute($name);

        return $route;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, array('sortable' => false, 'label' => 'Название страницы', 'template' => 'AmgPageBundle:Admin:raw_list_field.html.twig'))
            ->add('slug', null, array('sortable' => false))
            ->add('publishable', null, array('sortable' => false, 'label' => 'Опубликовано'))
            ->add('layout', null, array('sortable' => false, 'label' => 'Шаблон'))
            ->add('_action', 'actions', ['actions' => [
                'move' => ['template' => 'AmgPageBundle:Admin:_move.html.twig'],
                'edit' => [],
                'delete' => ['template' => 'AmgPageBundle:Admin:list__action_delete.html.twig'],
            ]]);
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $requiredParent = true;
        if ($this->getSubject() && $this->getSubject()->getId() && !$this->getSubject()->getParent()) {
            $requiredParent = false;
        }

        $form
            ->tab('Основное')
                ->with('Контент')
                    ->add(
                        'image',
                        'sonata_type_model_list',
                        ['required' => false],
                        [
                            'link_parameters' => [
                                'context' => 'gallery_media',
                                'lock_context' => ['main_image', 'gallery_media'],
                            ],
                        ]
                    )
                    ->add('content', 'ckeditor', ['config_name' => 'page'])
                    ->add('description', 'ckeditor', ['label' => 'Описание', 'config_name' => 'page'])
                ->end()
            ->end();

        if ($this->getSubject() && $this->getSubject()->getLevel() !== 0) {
            $form
                ->tab('Служебное')
                    ->with('Служебные параметры')
                        ->add('section', null, array('label' => 'Корневая страница раздела', 'required' => false))
                        ->add('parent', 'page_tree', array(
                            'class' => $this->getClass(),
                            'required' => $requiredParent,
                            'label' => 'Родительская страница',
                            'query_builder' => $this->getUserOwner(),
                        ))
                    ->end()
                ->end();
        }

        $form
            ->tab('Служебное')
                ->with('Служебные параметры')
                    ->add('slug', null, array('required' => false));

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            $form
                ->add('route', 'choice', array(
                    'required' => false,
                    'choices' => $this->getRoutesNameList()
                ))
                ->add('subRoutes', 'sonata_type_native_collection',
                    array(
                        'required' => false,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'delete_empty' => true,
                        'type' => 'choice',
                        'options' => array(
                            'label' => 'Route',
                            'choices' => $this->getRoutesNameList(),
                        )
                    )
                );
        }

        $layoutsAliases = $this->layoutManager->getLayoutsAliasesWithTitles();
        $layoutsAliases = ['' => 'По умолчанию'] + $layoutsAliases;
        $form
                    ->add('layout', 'choice', array(
                        'required' => false,
                        'choices' => $layoutsAliases,
                        'label' => 'Шаблон',
                        'label_attr' => array('style' => 'float: left; padding-right: 0.8em; width: 200px')
                    ))
                    ->add('childrenLayout', 'choice', array(
                        'required' => false,
                        'choices' => $layoutsAliases,
                        'label' => 'Шаблон дочерних страниц',
                        'label_attr' => array('style' => 'float: left; padding-right: 0.8em; width: 200px')
                    ))
                    /*->add(
                        $form->create('blocks', 'textarea', array(
                                'required' => false,
                                'label' => 'Блоки',
                                'attr' => array('class' => 'code_edit'))
                        )->addViewTransformer(new BlockArrayToTextTransformer())
                    )*/
                ->end()
            ->end()
        ;

        $form->tab('Основное')
            ->with('Параметры');
        $this->addPrivateUrl($this, $form);
        $form->add('view_date_page', 'date', ['required' => false, 'widget' => 'single_text', 'label' => 'Отображаемая дата (если пусто, то выводится дата редактирования)']);
        $form->add('publishable_date_page', 'checkbox', array('value' => 0, 'required' => false, 'label' => 'Не отображать дату публикации'));
        $form->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('publishable')
            ->add('slug')
            ->add('route')
            ->add('title')
            ->add('description')
            ->add('content')
        ;
    }

    public function prePersist($object)
    {
        $this->preSave($object);
        $this->updateEmbeddedContent($object);
    }

    public function preUpdate($object)
    {
        $this->preSave($object);
        $this->updateEmbeddedContent($object);
    }

    public function preRemove($object)
    {
        $this->updateEmbeddedContent($object);
    }

    public function preSave(PageInterface $object)
    {
        $object->setSubRoutes(array_unique($object->getSubRoutes()));
    }

    /**
     * @param Page $object
     */
    public function updateEmbeddedContent($object)
    {
        $embedder = $this->getConfigurationPool()->getContainer()->get('embedder');
        $manager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $items = $embedder->getEmbeddableItems($object->getContent());
        $object->removeEmbeddedContent();


        foreach ($items as $type => $ids) {
            $type = ucfirst($type);
            $className = "AppBundle:EmbeddedContent\\{$type}";
            if (!class_exists($className)) {
                continue;
            }
            $repository = $manager->getRepository('AppBundle:EmbeddedContent\\' . $type);
            $embeddables = $repository->findBy(['id' => $ids]);
            foreach ($embeddables as $embeddable) {
                $object->addEmbeddable($type, $embeddable);
            }
        }
    }

    protected function configureTabMenu(ItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if ($childAdmin || !in_array($action, array('edit'))) {
            return;
        }

        /* @var $admin Admin */
        $admin = $this->isChild() ? $this->getParent() : $this;

        $pageId = $admin->getRequest()->get('id');

        /** @var PageInterface $page */
        $page = $admin->getObject($pageId);

        $menu->addChild(sprintf('Блоки (%s)', count($page->getBlocks())), [
            'uri' => $admin->generateUrl('amg_page.admin.block.list', ['id' => $pageId])
        ]);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('revert_revision', '{id}/history/{base_rev_id}/{compare_rev_id}/revert/{field_name}');
        $collection->add('move', $this->getRouterIdParameter() . '/move/{direction}');
    }

    public function getTemplate($name)
    {
        if ('preview' === $name) {
            $this->pageTemplate = $this->getConfigurationPool()->getContainer()->get('amg_page.manager')->getPageLayoutTemplate($this->getSubject());
            return ':Page:preview.html.twig';
        }

        return parent::getTemplate($name);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title', null, ['label' => 'Заголовок']);
        $datagridMapper->add('publishable', null, ['label' => 'Опубликовано']);
        $datagridMapper->add('route', null, ['label' => 'Маршрут']);
    }
}
