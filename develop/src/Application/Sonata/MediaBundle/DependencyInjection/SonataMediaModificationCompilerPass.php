<?php
namespace Application\Sonata\MediaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SonataMediaModificationCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition('sonata.media.admin.media')
            ->addMethodCall('setTemplate', ['short_object_description', 'ApplicationSonataMediaBundle::short_object_description.html.twig']);
    }
}
