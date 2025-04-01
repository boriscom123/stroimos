<?php
namespace Amg\Bundle\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AutoAdminCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $extensions = $container->findTaggedServiceIds('app.sonata_autoadmin');

        $extendedAdminIds = [];
        foreach ($container->findTaggedServiceIds('sonata.admin') as $id => $attributes) {
            if (empty($attributes[0]['autoadmin'])) {
                continue;
            }

            $admin = $container->getDefinition($id);
            $entity = $admin->getArgument(1);
            $entityReflection = new \ReflectionClass($entity);

            foreach ($extensions as $extensionId => $extensionAttributes) {
                if ($this->isExtensionShouldBeEnabled($entityReflection, $extensionAttributes[0])) {
                    $admin->addMethodCall('addExtension', [new Reference($extensionId)]);

                    $extendedAdminIds[$id] = $id;
                }
            }
        }

        foreach ($extendedAdminIds as $id) {
            $admin = $container->getDefinition($id);
            $admin->addMethodCall('addExtension', [new Reference('amg_admin.autoadmin.fields_arranger')]);
        }
    }

    private function isExtensionShouldBeEnabled(\ReflectionClass $class, array $extensionAttributes)
    {
        return (!empty($extensionAttributes['interface']) && $this->classImplementsInterface($class, $extensionAttributes['interface']))
            || (!empty($extensionAttributes['trait']) && $this->classHasTrait($class, $extensionAttributes['trait']))
            || (!empty($extensionAttributes['field']) && $this->classHasProperty($class, $extensionAttributes['field']));
    }

    private function classHasTrait(\ReflectionClass $class, $name)
    {
        $traits = $class->getTraits();
        while($class = $class->getParentClass()) {
            $traits = array_merge($traits, $class->getTraits());
            foreach($class->getTraits() as $trait) {
                $traits = array_merge($traits, $trait->getTraits());
            }
        }

        if (empty($traits)) {
            return false;
        }

        if (isset($traits[$name])) {
            return true;
        }

        foreach ($traits as $trait) {
            if ($this->classHasTrait($trait, $name)) {
                return true;
            }
        }

        return false;
    }

    private function classHasProperty(\ReflectionClass $class, $name)
    {
        try {
            $class->getProperty($name);

            return true;
        } catch (\ReflectionException $e) {
            return false;
        }
    }

    private function classImplementsInterface(\ReflectionClass $class, $name)
    {
        return $class->implementsInterface($name);
    }
}
