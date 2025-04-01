<?php
namespace AppBundle\Model;

use AppBundle\Entity\Owner;

trait SingleOwnerTrait
{
    /**
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="Owner")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $owner;

    /**
     * @return Owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param Owner $owner
     * @return $this
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasStroiMosOwner()
    {
        return $this->getOwner()->getName() === Owner::OWNER_STROI_MOS;
    }

    /**
     * @param Owner $owner
     * @return bool
     */
    public function hasOwner(Owner $owner)
    {
        return $this->getOwner()->getId() === $owner->getId();
    }
}
