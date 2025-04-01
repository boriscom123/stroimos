<?php
namespace Amg\Bundle\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EditLockerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('sonata.admin') as $id => $attributes) {
            $admin = $container->getDefinition($id);
            $entity = $admin->getArgument(1);
            $entityReflection = new \ReflectionClass($entity);
            if ($entityReflection->implementsInterface('Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity')) {
                $admin->addMethodCall('addExtension', [new Reference('amg_admin.lock.admin_extension')]);
            }
        }
    }
}
