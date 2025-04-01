<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Menu;
use AppBundle\Entity\MenuNode;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MenuAdmin extends Admin
{
    protected $baseRoutePattern = 'menu';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, [
                'sortable' => false,
            ])
            ->addIdentifier('name', null, [
                'sortable' => false,
            ])
        ;
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('title')
            ->add('name')
        ;
    }

    protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if ($childAdmin || !in_array($action, array('edit'))) {
            return;
        }

        /* @var $admin AdminInterface */
        $admin = $this->isChild() ? $this->getParent() : $this;

        $objectId = $admin->getRequest()->get('id');

        $menu->addChild('Пункты меню', [
            'uri' => $admin->generateUrl('admin.menu_nodes.list', ['id' => $objectId])
        ]);
    }

    public function prePersist($object)
    {
        $this->createRootNode($object);
    }

    protected function createRootNode(Menu $menu)
    {
        $menuRootNode = new MenuNode();
        $menuRootNode->setNodeName($menu->getName());
        $menuRootNode->setTitle($menu->getTitle());

        $menu->setRootNode($menuRootNode);
    }

    public function toString($object)
    {
        return $object->getTitle() ?: '(меню без названия)';
    }
}
