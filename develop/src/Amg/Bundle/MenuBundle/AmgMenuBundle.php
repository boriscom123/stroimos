<?php

namespace Amg\Bundle\MenuBundle;

use Amg\Bundle\MenuBundle\DependencyInjection\Compiler\CurrentItemVotersPass;
use Amg\Bundle\MenuBundle\DependencyInjection\Compiler\MenuLoaderPass;
use Amg\Bundle\MenuBundle\DependencyInjection\Compiler\NodeFilterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AmgMenuBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new MenuLoaderPass());
        $container->addCompilerPass(new CurrentItemVotersPass());
        $container->addCompilerPass(new NodeFilterPass());
    }
}
