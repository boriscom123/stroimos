<?php
namespace AppBundle\Block;

use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SimpleTemplateBlock extends BaseBlockService
{
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderResponse($blockContext->getTemplate(), $blockContext->getSetting('parameters'))
            ->setTtl(600);
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => '',
            'use_cache' => true,
            'parameters' => []
        ]);
    }

    public function getCacheKeys(BlockInterface $block)
    {
        return $block->getSettings();
    }
}
