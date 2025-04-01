<?php
namespace Amg\Bundle\MenuBundle\Filter;

use Knp\Menu\NodeInterface;

interface NodeFilterInterface
{
    public function isAllowed(NodeInterface $node);
} 