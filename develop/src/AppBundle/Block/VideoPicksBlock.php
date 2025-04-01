<?php

namespace AppBundle\Block;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class VideoPicksBlock extends AbstractBlockService
{
    const DEFAULT_TEMPLATE = ':Block:video_picks.html.twig';

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
        $typeOptions = [
            'model_manager' => $this->modelManager,
            'class' => 'AppBundle\Entity\Video',
        ];

        return array_map(function ($i) use ($typeOptions) {
            return ["item{$i}", 'entity_reference', $typeOptions];
        }, range(1, 4));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $blockSettings = $blockContext->getBlock()->getSettings();

        return $this->renderResponse($blockContext->getTemplate(), [
            'items' => [
                $blockSettings['item1'],
                $blockSettings['item2'],
                $blockSettings['item3'],
                $blockSettings['item4'],
            ],
        ], $response);
    }
}
