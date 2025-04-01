<?php
namespace AppBundle\Model;

use AppBundle\Entity\Owner;

interface SingleOwner extends BaseOwner
{
    /**
     * @return Owner
     */
    public function getOwner();

    /**
     * @param $owner Owner
     */
    public function setOwner($owner);
}