<?php
namespace Amg\DataCore\Model\AdministrativeUnit;

use AppBundle\Entity\AdministrativeArea;
use AppBundle\Entity\CityDistrict;

interface AdministrativeUnitInterface
{
    /**
     * @return AdministrativeArea
     */
    public function getAdministrativeArea();

    /**
     * @return CityDistrict|null
     */
    public function getCityDistrict();
}
