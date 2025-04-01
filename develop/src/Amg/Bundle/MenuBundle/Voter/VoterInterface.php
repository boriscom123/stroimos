<?php
namespace Amg\Bundle\MenuBundle\Voter;

use Knp\Menu\ItemInterface;

interface VoterInterface
{
    /**
     * @param ItemInterface $item
     *
     * @return boolean|null
     */
    public function matchItem(ItemInterface $item);
}