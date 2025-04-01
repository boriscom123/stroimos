<?php

namespace Amg\Bundle\PageBundle\Menu\Loader;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Loader\LoaderInterface;

class ArrayPageLoader implements LoaderInterface
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function load($data)
    {
        $options = empty($data['route'])
            ? ['route' => 'page', 'routeParameters' => ['slug' => $data['slug']]]
            : ['route' => $data['route']];

        if (!empty($data['subRoutes'])) {
            $options['extras']['subroutes'] = $data['subRoutes'];
        }

        if (!empty($data['pageMenuBackground'])) {
            $options['extras']['menu_background'] = $data['pageMenuBackground'];
        }

        $item = $this->factory->createItem($data['title'], $options);

        foreach ($data['__children'] as $childNode) {
            $item->addChild($this->load($childNode));
        }

        return $item;
    }

    public function supports($data)
    {
        return is_array($data);
    }
}
