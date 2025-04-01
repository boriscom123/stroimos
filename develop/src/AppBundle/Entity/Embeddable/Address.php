<?php
namespace AppBundle\Entity\Embeddable;

use AppBundle\Model\GeoPointTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Address
{
    use GeoPointTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $text;

    /**
     * @var string
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $geoPolygon;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getGeoPolygon()
    {
        return $this->geoPolygon;
    }

    public function getGeoPolygonString()
    {
        if (!$this->geoPolygon) {
            return '';
        }

        return implode(';', array_filter(array_map(function ($outline) {
            return implode(',', array_map([$this, 'toLonLat'], $outline));
        }, json_decode($this->geoPolygon, true))));
    }

    /**
     * @param string $geoPolygon
     * @return $this
     */
    public function setGeoPolygon($geoPolygon)
    {
        $this->geoPolygon = $geoPolygon;

        return $this;
    }

    public function __toString()
    {
        return $this->getText() ?: '(неуказанный адрес)';
    }

    public function getLonLat()
    {
        if (!$this->geoPoint) {
            return '';
        }

        return $this->toLonLat(json_decode($this->geoPoint, true));
    }

    private function toLonLat(array $coords)
    {
        list($lon, $lat) = $coords;

        return sprintf('%.6f,%.6f', $lon, $lat);
    }
}
