<?php
namespace AppBundle\Admin;

use Amg\DataCore\ValueObject\EntityReference;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Sonata\AdminBundle\Route\RouteCollection;

class ThreadAdmin extends Admin
{
    protected $datagridValues = [
        '_sort_by' => 'lastCommentAt',
        '_sort_order' => 'DESC',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id', null, ['read_only' => true, 'label' => 'Идентификатор треда']);

//        if (interface_exists('Sonata\\ClassificationBundle\\Model\\CategoryInterface')) {
//            $formMapper->add('category');
//        }

//        $formMapper
//            ->add('permalink', null, ['required' => false])
//            ->add('isCommentable', null, ['required' => false])
//        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('permalink')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id', null, ['template' => ':ThreadAdmin:id.html.twig', 'sortable' => false]);
        $listMapper->add('publicationTitle', null, ['template' => ':ThreadAdmin:publication_title.html.twig', 'sortable' => false]);
        $listMapper->add('permalink', 'url', ['sortable' => false]);
        $listMapper->add('numComments', null, ['sortable' => false]);
        $listMapper->add('lastCommentAt');
    }

    public function getPublicationByReference($referenceString)
    {
        $entityReference = EntityReference::createFromString($referenceString);

        /** @var ModelManagerInterface $modelManager */
        $modelManager = $this->getModelManager();

        $publication = $modelManager->find($entityReference->getClass(), $entityReference->getId());

        return $publication;
    }

    public function getPublicationClassNameByReference($referenceString)
    {
        $entityReference = EntityReference::createFromString($referenceString);

        return $entityReference->getClass();
    }

    protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit'))) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;

        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            'Редактирование',
            ['uri' => $admin->generateUrl('edit', ['id' => $id])]
        );

        $menu->addChild(
            'Комментарии',
            ['uri' => $admin->generateUrl('admin.comment.list', ['id' => $id])]
        );
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
        $collection->remove('create');
    }

    public function getSubject()
    {
        if ($this->subject === null && $this->request) {
            $id = $this->request->get($this->getIdParameter());
            $this->subject = $this->getModelManager()->find($this->getClass(), $id);
        }

        return $this->subject;
    }
}
