<?php
namespace Amg\DataCore\Model\Addressable;

use Amg\DataCore\Model\AdministrativeUnit\AdministrativeUnitTrait;
use AppBundle\Entity\Embeddable\Address;
use Doctrine\ORM\Mapping as ORM;

trait AddressableTrait
{
    use AdministrativeUnitTrait;

    /**
     * @var Address
     * @ORM\Embedded(class="AppBundle\Entity\Embeddable\Address")
     */
    private $address;

    /**
     * @return \AppBundle\Entity\Embeddable\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }
}
