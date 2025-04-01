<?php
namespace Amg\Bundle\AdminBundle;

use Amg\Bundle\AdminBundle\DependencyInjection\Compiler\AutoAdminCompilerPass;
use Amg\Bundle\AdminBundle\DependencyInjection\Compiler\EditLockerCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AmgAdminBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AutoAdminCompilerPass(), PassConfig::TYPE_BEFORE_REMOVING);
        $container->addCompilerPass(new EditLockerCompilerPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}
