<?php

namespace Amg\Bundle\MenuBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class NodeFilterPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $menuFactoryDefinition = $container->getDefinition('amg_menu.menu.factory');

        foreach ($container->findTaggedServiceIds('amg_menu.node_filter') as $loaderId => $tags) {
            $menuFactoryDefinition->addMethodCall('addNodeFilter', [new Reference($loaderId)]);
        }
    }
}