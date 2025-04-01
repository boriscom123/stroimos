<?php

namespace Amg\Bundle\PageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('amg_page');

        $rootNode
            ->children()
                ->arrayNode('page')
                    ->isRequired()
                    ->children()
                        ->scalarNode('class')->cannotBeEmpty()->end()
                        ->scalarNode('admin_class')->end()
                        ->scalarNode('admin_controller')->end()
                    ->end()
                ->end()
            ->end()

            ->children()
                ->arrayNode('block')
                    ->isRequired()
                    ->children()
                        ->scalarNode('class')->cannotBeEmpty()->end()
                        ->scalarNode('admin_class')->end()
                        ->scalarNode('admin_controller')->end()
                    ->end()
                ->end()
            ->end()

            ->children()
                ->arrayNode('route')
                    ->children()
                        ->scalarNode('name')->defaultValue('page')->end()
                        ->scalarNode('controller')->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end()

            ->children()
                ->arrayNode('layouts')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('title')->cannotBeEmpty()->end()
                            ->scalarNode('template')->cannotBeEmpty()->end()
                            ->arrayNode('containers')->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}