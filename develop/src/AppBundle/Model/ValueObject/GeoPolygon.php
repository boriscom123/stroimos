<?php
namespace AppBundle\Model\ValueObject;

class GeoPolygon
{
    /** @var GeoPoint[] */
    private $outerContour = [];

    /** @var array<GeoPoint[]> */
    private $innerContours = [];

    /**
     * GeoPolygon constructor.
     *
     * @param \AppBundle\Model\ValueObject\GeoPoint[] $outerContour
     * @param array $innerContours
     */
    public function __construct(array $outerContour, array $innerContours = [])
    {
        $this->outerContour = $outerContour;
        $this->innerContours = $innerContours;
    }

    public static function createFromGmlCoordinates($string)
    {
        $geoPoints = array_map('AppBundle\Model\ValueObject\GeoPoint::createFromLonLatString', explode(' ', trim($string)));

        return new self($geoPoints);
    }

    public function getJsonForYandex()
    {
        $getCoords = function (GeoPoint $geoPoint) {
            return [$geoPoint->getLongitude(), $geoPoint->getLatitude()];
        };

        $contours = [];
        $contours[] = array_map($getCoords, $this->outerContour);
        foreach ($this->innerContours as $innerContour) {
            $contours[] = array_map($getCoords, $innerContour);
        }

        return json_encode($contours);
    }
}
