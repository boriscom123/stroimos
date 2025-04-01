<?php

namespace Amg\Bundle\PageBundle\Menu\Factory;

use Amg\Bundle\PageBundle\Model\PageInterface;
use Knp\Menu\Factory\ExtensionInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class PageExtension
 * @package Amg\Bundle\PageBundle\Menu\Factory
 *
 * Must gone prior to RoutingExtension (have higher priority)
 */
class PageExtension implements ExtensionInterface
{
    private $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function buildOptions(array $options = array())
    {
        if (!empty($options['page']) && $options['page'] instanceof PageInterface) {
            /** @var PageInterface $page */
            $page = $options['page'];

            $options['route'] = $page->getRoute() ?: 'page';
            $options['routeParameters']= $page->getRoute() ? [] : ['slug' => $page->getSlug()];

            $options['extras']['subroutes'] = $page->getSubRoutes();
        }

        return $options;
    }

    public function buildItem(ItemInterface $item, array $options)
    {
    }
}
