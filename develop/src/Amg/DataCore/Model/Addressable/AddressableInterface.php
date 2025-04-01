<?php
namespace Amg\DataCore\Model\Addressable;

interface AddressableInterface
{
    /**
     * @return \AppBundle\Entity\Embeddable\Address
     */
    public function getAddress();

    /** @return \AppBundle\Entity\AdministrativeUnit */
    public function getAdministrativeUnit();
}
