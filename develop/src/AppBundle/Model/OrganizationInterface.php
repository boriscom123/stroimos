<?php
namespace AppBundle\Model;

use AppBundle\Entity\Organization;

interface OrganizationInterface
{
    /**
     * @return Organization
     */
    public function getOrganization();

    /**
     * @param Organization $organization
     * @return $this
     */
    public function setOrganization($organization);
}
