<?php

namespace Amg\Bundle\PageBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AmgPageExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        foreach (['page', 'block', 'route'] as $configSection) {
            foreach ($config[$configSection] as $parameter => $value) {
                if (!empty($value)) {
                    $container->setParameter("amg_page.$configSection.$parameter", $value);
                }
            }
        }

        if (!empty($config['layouts_paths'])) {
            $layoutManager = $container->getDefinition('amg_page.layout.manager');
            foreach ($config['layouts_paths'] as $layoutsPath) {
                $layoutManager->addMethodCall('addLayoutsFromPath', [$layoutsPath]);
            }
        }

        if (!empty($config['layouts'])) {
            $container->getDefinition('amg_page.layout.manager')->replaceArgument(0, $config['layouts']);
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('cmf_routing', [
            'chain' => [
                'routers_by_id' => [
                    'router.default' => 200,
                    'amg_page.router' => 100,
                ],
            ],
            'dynamic' => [
                'enabled' => false,
            ],
        ]);
    }
}
