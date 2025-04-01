<?php

namespace Amg\Bundle\PageBundle\Menu\Loader;

use Amg\Bundle\PageBundle\Model\PageInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\Loader\LoaderInterface;

class PageLoader implements LoaderInterface
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function load($data)
    {
        /** @var PageInterface $data */

        $item = $this->factory->createItem($data->getTitle(), ['page' => $data]);

        foreach ($data->getChildren() as $childNode) {
            $item->addChild($this->load($childNode));
        }

        return $item;
    }

    public function supports($data)
    {
        return $data instanceof PageInterface;
    }
}
