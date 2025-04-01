<?php

namespace Amg\Bundle\MenuBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AmgMenuExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (!empty($config['yaml_loader_paths'])) {
            $this->createYamlLoaders($config['yaml_loader_class'], $config['yaml_loader_paths'], $container);
        }

        $this->registerVoters($container, $config);
    }

    private function createYamlLoaders($loaderClass, $paths, ContainerBuilder $container)
    {
        $menuProviderDefinition = $container->getDefinition('amg_menu.provider');
        foreach ($paths as $path) {
            $menuProviderDefinition->addMethodCall('addMenuLoader', [
                new Definition($loaderClass, [$path])
            ]);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param $config
     */
    protected function registerVoters(ContainerBuilder $container, $config)
    {
        if (!empty($config['path_prefix_voter'])) {
            $container
                ->getDefinition('amg_menu.menu.factory')
                ->addMethodCall('addCurrentItemVoter', [
                    new Reference('amg_menu.voter.request_uri_prefix')
                ]);
        }

        if (!empty($config['sub_routes_voter'])) {
            $container
                ->getDefinition('amg_menu.menu.factory')
                ->addMethodCall('addCurrentItemVoter', [
                    new Reference('amg_menu.voter.sub_routes_voter')
                ]);
        }
    }
}
