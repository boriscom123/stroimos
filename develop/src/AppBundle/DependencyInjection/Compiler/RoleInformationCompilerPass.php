<?php
namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RoleInformationCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $adminAttributes = [];

        $taggedServiceIds = $container->findTaggedServiceIds('sonata.admin');
        foreach ($taggedServiceIds as $id => $tags) {
            $attributes = $tags[0];

            if (empty($attributes['group'])) {
                throw new \LogicException(sprintf('Group not specified for admin service "%s"', $id));
            }

            if (empty($attributes['label'])) {
                throw new \LogicException(sprintf('Label not specified for admin service "%s"', $id));
            }

            /** @see \Sonata\AdminBundle\Security\Handler\RoleSecurityHandler::getBaseRole */
            $baseRole = 'ROLE_' . str_replace('.', '_', strtoupper($id)) . '_%s';

            $adminAttributes[$baseRole] = [
                'code' => $id,
                'group' => $attributes['group'],
                'label' => $attributes['label'],
                'label_catalogue' => isset($attributes['label_catalogue']) ? $attributes['label_catalogue'] : 'SonataAdminBundle',
            ];
        }

        $definition = $container->getDefinition('sonata.user.editable_role_builder');
        $definition->addMethodCall('setAdminAttributes', [$adminAttributes]);
    }
}
