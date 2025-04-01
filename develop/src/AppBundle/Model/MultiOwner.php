<?php
namespace AppBundle\Model;

use AppBundle\Entity\Owner;
use Doctrine\Common\Collections\ArrayCollection;

interface MultiOwner extends BaseOwner
{
    /**
     * @return Owner[]|ArrayCollection
     */
    public function getOwners();

    /**
     * @param Owner[]|ArrayCollection $owners
     */
    public function setOwners($owners);
}