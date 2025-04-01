<?php
namespace AppBundle\Model;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Model\ValueObject\FunctionalPurpose;

interface ConstructionObjectInterface extends
    EntitledInterface,
    TeasingInterface
{
    /** @return string */
    public function getEntityReference();

    /** @return string */
    public function getAddressText();

    /** @return array */
    public function getGeoPointCoordinatesInGeoJson();

    /** @return \AppBundle\Entity\AdministrativeUnit */
    public function getAdministrativeUnit();

    /** @return FunctionalPurpose */
    public function getFunctionalPurpose();

    /** @return ConstructionStatus */
    public function getConstructionStatus();

    /** @return int|null */
    public function getConstructionStartYear();

    /** @return int|null */
    public function getConstructionEndYear();

    /** @return string[] */
    public function getConstructionStatusTranslations();
}
