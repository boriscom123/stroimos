<?php

namespace AppBundle\Admin;

use Amg\Bundle\PageBundle\Layout\LayoutManager;
use AppBundle\Entity\Category;
use AppBundle\Entity\Menu;
use AppBundle\Entity\MenuNode;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class MenuNodesAdmin extends Admin
{
    use \Amg\Bundle\AdminBundle\Helper\RoutesListTrait;

    protected $maxPerPage = 2500;

    protected $maxPageLinks = 2500;

    /**
     * @var LayoutManager
     */
    protected $layoutManager;

    public function createQuery($context = 'list')
    {
        /** @var Menu $menu */
        $menu = $this->getParent()->getSubject();

        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);

        $rootAliases = $query->getRootAliases();
        $rootAlias = reset($rootAliases);

        $query->where($rootAlias.'.root = :parent');
        $query->setParameter('parent', $menu->getRootNode());
        $query->orderBy($rootAlias . '.root, ' . $rootAlias . '.lft', 'ASC');

        return $query;
    }

    public function hasRoute($name)
    {
        if ('delete' === $name) {
            $subject = $this->getSubject();
            if (is_object($subject) && !$subject->getChildren()->isEmpty()) {
                return false;
            }
        }

        return parent::hasRoute($name);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('move', $this->getRouterIdParameter() . '/move/{direction}');
    }

    public function generateObjectUrl($name, $object, array $parameters = array(), $absolute = false)
    {
        $parameters['id'] = $this->getUrlsafeIdentifier($object);

        return $this->generateUrl($name, $parameters, $absolute);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, [
                'sortable' => false,
                'label' => 'Название пункта меню',
                'template' => 'AmgPageBundle:Admin:raw_list_field.html.twig',
            ])
            ->addIdentifier('nodeName', null, [
                'sortable' => false,
                'label' => 'Код',
                'template' => ':Admin:raw_list_field.html.twig',
            ])
            ->add('type', 'choice', [
                'choices' => MenuNode::$linkTypeTitles
            ])
            ->add('_action', 'actions', ['actions' => [
                'move' => ['template' => 'AmgPageBundle:Admin:_move.html.twig'],
                'edit' => [],
            ]]);
        ;
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        /** @var Menu $menu */
        $menu = $form->getAdmin()->getParent()->getSubject();

        $type = $this->getSubject()->getType();
        $hiddenClass = 'hidden-type';

        $form
            ->add('title')
            ->add('nodeName')
        ;

        if (!$this->getSubject()->getId() || $this->getSubject()->getLvl() > 0) {
            $form->add('parent', 'menu_tree', array(
                'required' => true,
                'label' => 'Родительский пункт меню',
                'menu' => $menu,
                'empty_data' => $menu->getRootNode(),
            ));
        }

        $form
            ->add('publishable', 'checkbox', array(
                'required' => false,
                'label_attr' => array('style' => 'float: left; padding-right: 0.8em;'),
            ))
            ->add('type', 'choice', [
                'choices' => MenuNode::$linkTypeTitles,
                'attr' => ['class' => "type-choice"],
            ])
            ->add('page', 'sonata_type_model_list', [
                'attr' => ['class' => ('page' !== $type ? $hiddenClass : '') . " type-field type-page"],
                'required' => false,
                'btn_add' => false,
            ], [
                'placeholder' => 'Выберите страницу',
            ])
            ->add('construction', 'sonata_type_model_list', [
                'attr' => ['class' => ('construction' !== $type ? $hiddenClass : '') . " type-field type-construction"],
                'required' => false,
                'btn_add' => false,
            ], [
                'placeholder' => 'Выберите объект строительства',
            ])
            ->add('post', 'sonata_type_model_list', [
                'attr' => ['class' => ('post' !== $type ? $hiddenClass : '') . " type-field type-post"],
                'required' => false,
                'btn_add' => false
            ], [
                'placeholder' => 'Выберите публикацию',
                'link_parameters' => [
                    'category_alias' => Category::CATEGORY_NEWS
                ]
            ])
            ->add('route', 'choice', array(
                'attr' => ['class' => ('route' !== $type ? $hiddenClass : '') . " type-field type-route"],
                'required' => false,
                'choices' => $this->getRoutesNameList()
            ))
            ->add('uri', null, [
                'attr' => ['class' => ('uri' !== $type ? $hiddenClass : '') . " type-field type-uri"],
            ])
//            ->add('stadium', 'sonata_type_model_list', [
//                'required' => false,
//                'btn_add' => false,
//            ], [
//                'placeholder' => 'Выберите стадион',
//            ])
        ;
    }

    public function prePersist($object)
    {
        $this->saveParentMenuReference($object);
    }

    public function preUpdate($object)
    {
        $this->saveParentMenuReference($object);
    }

    private function saveParentMenuReference($object)
    {
    }

    public function toString($object)
    {
        return $object->getTitle() ?: '(пункт меню без названия)';
    }

    public function getTemplate($name)
    {
        if ('edit' === $name) {
            return ':Admin:Menu/menu_node_edit.html.twig';
        }

        return parent::getTemplate($name);
    }
}
