<?php

namespace AppBundle\Menu\Factory;

use AppBundle\Entity\Page;
use AppBundle\Routing\EntityUrlGenerator;
use Knp\Menu\Factory\ExtensionInterface;
use Knp\Menu\ItemInterface;

/**
 * Class PageExtension
 * @package AppBundle\Menu\Factory
 *
 * Must gone prior to RoutingExtension (have higher priority)
 */
class LinkedEntityExtension implements ExtensionInterface
{
    private $generator;

    public function __construct(EntityUrlGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function buildOptions(array $options = array())
    {
        if (!empty($options['page']) && $options['page'] instanceof Page) {
            $options['link_type'] = 'page';
        }

        if (empty($options['link_type']) || empty($options[$options['link_type']])) {
            return $options;
        }
        
        $entity = $options[$options['link_type']];

        list($options['route'], $options['routeParameters']) = $this->generator->getRouteAndParameters($entity);

        if ($entity instanceof Page) {
            $options['extras']['subroutes'] = $entity->getSubRoutes();
        }

        return $options;
    }

    public function buildItem(ItemInterface $item, array $options)
    {
    }
}
