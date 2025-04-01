<?php
namespace AppBundle\Model;

use AppBundle\Entity\Owner;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

trait MultiOwnerTrait
{
    /**
     * @var Owner[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Owner")
     */
    protected $owners;

    /**
     * @return Owner[]|ArrayCollection
     */
    public function getOwners()
    {
        return $this->owners ?: $this->owners = new ArrayCollection();
    }

    /**
     * @param Owner[]|ArrayCollection $owners
     */
    public function setOwners($owners)
    {
        $this->owners = $owners;
    }

    /**
     * @return bool
     */
    public function hasStroiMosOwner()
    {
        $stroiMos = Owner::OWNER_STROI_MOS;
        $owners = $this->getOwners();
        /** Если у материала нет владельцев, то считаем, что он принадлежит stroi_mos */
        if(count($owners) === 0) {
            return true;
        }

        return $this->getOwners()->exists(function ($key, $owner) use ($stroiMos) {
            /** @var $owner Owner */
            return $owner->getName() === $stroiMos;
        });
    }

    /**
     * @param Owner $owner
     * @return bool
     */
    public function hasOwner(Owner $owner)
    {
        return $this->getOwners()->exists(function ($key, $objectOwner) use ($owner) {
            /** @var Owner $objectOwner*/
            return $objectOwner->getId() === $owner->getId();
        });
    }
}