<?php

namespace AppBundle\Twig;

use AppBundle\Block\AbstractBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BlockTwigExtension extends \Twig_Extension
{
    use ContainerAwareTrait;

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('block_path', [$this, 'blockPath']),
        ];
    }

    public function blockPath(AbstractBlockService $block, BlockContextInterface $blockContext, array $options = array())
    {
        $settings = [];

        foreach ($block->getDefaultSettings() as $key => $defaultValue) {
            if ($blockContext->getSetting($key) !== $defaultValue) {
                $settings[$key] = $blockContext->getSetting($key);
            }
        }

        $path = $this->container->get('router')
            ->generate('api_block_render', array_merge(
                ['type' => $blockContext->getBlock()->getType()],
                $settings,
                $options
            ));

        return $path;
    }

    public function getName()
    {
        return 'block';
    }
}
