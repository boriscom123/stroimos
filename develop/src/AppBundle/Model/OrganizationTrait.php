<?php
namespace AppBundle\Model;

use AppBundle\Entity\Organization;

trait OrganizationTrait
{
    /**
     * @var Organization
     *
     * @ORM\ManyToOne(targetEntity="Organization", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $organization;

    /**
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param Organization $organization
     * @return $this
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;

        return $this;
    }
}
