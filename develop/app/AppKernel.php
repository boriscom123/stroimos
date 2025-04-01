<?php

use Nelmio\CorsBundle\NelmioCorsBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),
            new Application\Sonata\FormatterBundle\ApplicationSonataFormatterBundle(),

            new SimpleThings\EntityAudit\SimpleThingsEntityAuditBundle(),

            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            new JMS\SerializerBundle\JMSSerializerBundle(),

            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Sonata\FormatterBundle\SonataFormatterBundle(),
            new Sonata\SeoBundle\SonataSeoBundle(),
            new Presta\SitemapBundle\PrestaSitemapBundle(),

            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            new Amg\Bundle\PageBundle\AmgPageBundle(),
            new Amg\Bundle\AdminBundle\AmgAdminBundle(),

            new FOS\ElasticaBundle\FOSElasticaBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new AppBundle\AppBundle(),

            new Amg\Bundle\FormBundle\AmgFormBundle(),
            new Amg\Bundle\TagBundle\AmgTagBundle(),

            new Snc\RedisBundle\SncRedisBundle(),

            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),

            new \Sonata\CacheBundle\SonataCacheBundle(),
            new Nmure\CrawlerDetectBundle\CrawlerDetectBundle(),
            new Stroi\MobileBundle\StroiMobileBundle(),
            new ApiBundle\ApiBundle(),
            new Sentry\SentryBundle\SentryBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
//            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new NelmioCorsBundle();

            if ($this->getEnvironment() !== 'test') {
                $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            }
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
