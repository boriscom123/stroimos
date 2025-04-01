<?php

namespace AppBundle;

use AppBundle\DependencyInjection\Compiler\RoleInformationCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RoleInformationCompilerPass(), PassConfig::TYPE_BEFORE_REMOVING);

        $environment = $container->getParameter('kernel.root_dir').$container->getParameter('kernel.environment');
        $hash        = date('YmdHis').hash('md5', $environment);
        $container->setParameter('cache_namespace', $hash);
    }
}
