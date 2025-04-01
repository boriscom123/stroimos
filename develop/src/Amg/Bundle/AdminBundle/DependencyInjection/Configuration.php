<?php
namespace Amg\Bundle\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('amg_admin');

        $rootNode->children()
            ->arrayNode('fields_mapping')
                ->isRequired()
                ->requiresAtLeastOneElement()
                ->prototype('array')->children()
                    ->arrayNode('fields')
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode('options')->children()
                        ->scalarNode('class')->end()
                        ->scalarNode('collapsed')->end()
                        ->scalarNode('description')->end()
                        ->scalarNode('translation_domain')->end()
                    ->end()->end()
                ->end()->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
