<?php

namespace AppBundle\Block;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class GalleryPickBlock extends AbstractBlockService
{
    const DEFAULT_TEMPLATE = ':Block:gallery_pick.html.twig';

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var ModelManagerInterface
     */
    protected $modelManager;

    /**
     * @param EntityManager $em
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    public function setModelManager(ModelManagerInterface $modelManager)
    {
        $this->modelManager = $modelManager;
    }

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack($requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getDefaultSettings()
    {
        return [
            'template' => self::DEFAULT_TEMPLATE,
            'settings' => [],
        ];
    }

    public function getFormSettingsKeys(FormMapper $form)
    {
        return [
            ['item', 'entity_reference', [
                'model_manager' => $this->modelManager,
                'class' => 'AppBundle\Entity\Gallery',
            ]],
        ];
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $blockSettings = $blockContext->getBlock()->getSettings();

        return $this->renderResponse($blockContext->getTemplate(), [
            'item' => $blockSettings['item'],
        ], $response);
    }
}
