<?php
namespace AppBundle\Model;

use AppBundle\Entity\Owner;

interface BaseOwner
{
    /**
     * @param Owner $owner
     * @return bool
     */
    public function hasOwner(Owner $owner);
}