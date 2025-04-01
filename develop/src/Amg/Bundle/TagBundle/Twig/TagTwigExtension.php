<?php
namespace Amg\Bundle\TagBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class TagTwigExtension extends \Twig_Extension
{
    use ContainerAwareTrait;

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('tag_usage_count', [$this->container->get('amg_tag.manager'), 'getUsageCount'])
        ];
    }

    public function getName()
    {
        return 'tag_extension';
    }
}