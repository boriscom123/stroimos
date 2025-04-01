<?php
namespace Amg\DataCore\Model\AdministrativeUnit;

use AppBundle\Entity\AdministrativeUnit;
use AppBundle\Entity\CityDistrict;
use Doctrine\ORM\Mapping as ORM;

trait AdministrativeUnitTrait
{
    /**
     * @var AdministrativeUnit
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AdministrativeUnit")
     */
    private $administrativeUnit;

    /**
     * @return AdministrativeUnit
     */
    public function getAdministrativeUnit()
    {
        return $this->administrativeUnit;
    }

    /**
     * @param AdministrativeUnit $administrativeUnit
     */
    public function setAdministrativeUnit($administrativeUnit)
    {
        $this->administrativeUnit = $administrativeUnit;
    }

    public function getAdministrativeArea()
    {
        $administrativeUnit = $this->getAdministrativeUnit();
        if (!$administrativeUnit) {
            return null;
        }

        return ($administrativeUnit instanceof CityDistrict) ? $administrativeUnit->getParent() : $administrativeUnit;
    }

    public function getCityDistrict()
    {
        $administrativeUnit = $this->getAdministrativeUnit();
        if ($administrativeUnit instanceof CityDistrict) {
            return $administrativeUnit;
        }

        return null;
    }
}
