<?php

namespace Amg\Bundle\PageBundle\Admin;

use Amg\Bundle\PageBundle\Layout\LayoutManager;
use AppBundle\Block\AbstractBlockService;
use AppBundle\Entity\Block;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\BlockBundle\Block\BlockServiceManagerInterface;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

class BlockAdmin extends Admin
{
    protected $parentAssociationMapping = 'page';

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'position',
    );

    /**
     * @var BlockServiceManagerInterface
     */
    protected $blockManager;

    /**
     * @var LayoutManager
     */
    protected $layoutManager;

    public function setLayoutManager(LayoutManager $layoutManager)
    {
        $this->layoutManager = $layoutManager;
    }


    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('type', null, ['template' => ':Admin:Block/translated_type.html.twig'])
            ->addIdentifier('title', null)
            ->addIdentifier('enabled', null, [
                'label' => 'Опубликовано',
                'template' => ':Admin:Block/enabled.html.twig',
                'route' => ['name' => 'toggleEnable' ]
            ])
            ->addIdentifier('position', null, ['label' => 'Позиция'])
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('settings', null, ['label' => 'Заголовок']);
        $datagridMapper->add('enabled', null, ['label' => 'Опубликовано']);

        $choices = array_combine(
            Block::$types,
            array_map(
                function($item) {
                    return 'block_type.' . $item;
                },
                Block::$types
            )
        );
        $datagridMapper->add('type', null, array(), 'choice', array('choices' => $choices));
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        /** @var  Block $blockEntity */
        $blockEntity = $this->getSubject();

        $page = $this->getParent()->getSubject();

        $containersNames = $this->layoutManager->getContainersNames($page->getLayout());

        if ($blockEntity->getId() === null) { // new block
            $type = $this->request->get('type');
            $blockEntity->setType($type);
            $blockEntity->setPosition($this->getMaxPosition($type) + 1);
            $blockEntity->setPage($page);

            if (isset($containersNames['content'])) {
                $blockEntity->setContainer('content');
            }
        }

        if ($blockEntity->getPage()->getId() != $page->getId()) {
            throw new \RuntimeException('The page reference on BlockAdmin and parent admin are not the same');
        }

        if ($this->isGranted('MASTER')) {
            $form
                ->with('Служебное')
                ->add('type', 'text', array('required' => true, 'label' => 'Тип блока'))
                ->add('container', 'choice', array(
                    'required' => false,
                    'choices' => $containersNames,
                    'label' => 'Контейнер',
                    'label_attr' => array('style' => 'float: left; padding-right: 0.8em; width: 200px')
                ))
                ->add('enabled', 'checkbox', array('required' => false, 'label' => 'Опубликовано'))
                ->add('position', 'number', array('required' => false, 'label' => 'Позиция'))
                ->end();
        }

        $blockService = $this->blockManager->get($blockEntity);

        if ($blockService instanceof AbstractBlockService) {
            $blockService->setAdmin($this);
        }

        $blockService->buildEditForm($form, $blockEntity);
    }

    public function setBlockManager(BlockServiceManagerInterface $blockManager)
    {
        $this->blockManager = $blockManager;
    }

    protected function getMaxPosition($type) {
        /** @var Admin $admin */
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $class = $this->getClass();
        $maxPosition = $modelManager->getEntityManager($class)
            ->createQuery("SELECT MAX(b.position) FROM {$class} b WHERE b.type = :type")
            ->setParameter('type', $type)
            ->getSingleScalarResult();

        return $maxPosition;
    }

    /**
     * {@inheritdoc}
     */
    public function getPersistentParameters()
    {
        $parameters = parent::getPersistentParameters();

        if ($this->hasRequest()) {
            $parameters['type']  = $this->getRequest()->get('type');
        }

        return $parameters;
    }

    public function supportsPreviewMode()
    {
        $subject = $this->getSubject();
        if($subject instanceof Block && $subject->getType() === Block::TYPE_SERVICE_BANNER) {
            $this->supportsPreviewMode = true;
        }

        return parent::supportsPreviewMode();
    }

    public function getTemplate($name)
    {
        if ('preview' === $name) {
            return ':Block:preview.html.twig';
        }

        return parent::getTemplate($name);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection
            ->add("toggleEnable", $this->getRouterIdParameter().'/toggleEnable')
        ;
    }
}
