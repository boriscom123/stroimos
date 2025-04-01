<?php

namespace Amg\Bundle\MenuBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MenuLoaderPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $menuProviderDefinition = $container->getDefinition('amg_menu.provider');

        foreach ($container->findTaggedServiceIds('amg_menu.loader') as $loaderId => $tags) {
            $menuProviderDefinition->addMethodCall('addMenuLoader', [new Reference($loaderId)]);
        }
    }
}