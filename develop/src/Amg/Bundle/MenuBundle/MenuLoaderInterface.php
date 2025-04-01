<?php
namespace Amg\Bundle\MenuBundle;

use Knp\Menu\NodeInterface;

interface MenuLoaderInterface
{
    /**
     * @param string $name
     * @return NodeInterface|null
     */
    public function findMenu($name);

    /**
     * @param string $name
     * @return boolean
     */
    public function hasMenu($name);
}