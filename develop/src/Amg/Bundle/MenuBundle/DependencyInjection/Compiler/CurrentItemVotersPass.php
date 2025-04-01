<?php

namespace Amg\Bundle\MenuBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CurrentItemVotersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $menuFactoryDefinition = $container->getDefinition('amg_menu.menu.factory');

        foreach ($container->findTaggedServiceIds('amg_menu.current_item_voter') as $loaderId => $tags) {
            foreach ($tags as $tag) {
                $priority = !empty($tag['priority'])
                    ? $tag['priority']
                    : 0;

                $menuFactoryDefinition->addMethodCall('addCurrentItemVoter', [new Reference($loaderId), $priority]);
            }
        }
    }
}