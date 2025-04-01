<?php

namespace ExtraBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ExtraBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        if (
            !$container->hasParameter('activity_collection_enable') ||
            !$container->getParameter('activity_collection_enable')
        ) {
            $container->removeDefinition('extra.user_activity.listener');
            $container->removeDefinition('extra.user_activity.collector');
        }
    }
}
