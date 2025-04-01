<?php
namespace AppBundle\Model;

use AppBundle\Model\ValueObject\GeoPoint;

trait GeoPointTrait
{
    /**
     * @var string|null
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $geoPoint;

    /**
     * @var GeoPoint
     */
    private $_geoPoint;

    /**
     * @return GeoPoint|null
     */
    public function getGeoPoint()
    {
        if (null === $this->_geoPoint) {
            return $this->_geoPoint = $this->geoPoint ? GeoPoint::createFromLonLatString($this->geoPoint) : null;
        }

        return $this->_geoPoint;
    }

    /**
     * @param string|GeoPoint $geoPoint
     *
     * @return $this
     */
    public function setGeoPoint($geoPoint)
    {
        if ($geoPoint instanceof GeoPoint) {
            $this->_geoPoint = $geoPoint;
            $this->geoPoint = $geoPoint->getLonLatString();
        } else {
            $this->geoPoint = $geoPoint;
        }

        return $this;
    }
}
