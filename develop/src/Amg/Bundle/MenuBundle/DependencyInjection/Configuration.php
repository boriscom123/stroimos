<?php

namespace Amg\Bundle\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('amg_menu');

        $rootNode->children()
            ->scalarNode('yaml_loader_class')
                ->defaultValue('Amg\\Bundle\\MenuBundle\\YamlMenuLoader')
            ->end()
            ->arrayNode('yaml_loader_paths')
                ->prototype('scalar')
                ->end()
            ->end()
            ->booleanNode('path_prefix_voter')
                ->defaultFalse()
            ->end()
            ->booleanNode('sub_routes_voter')
                ->defaultFalse()
            ->end()
        ;

        return $treeBuilder;
    }
}
