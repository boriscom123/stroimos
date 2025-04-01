<?php
namespace AppBundle\Model\ValueObject;

final class GeoPoint
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    public static function createFromLonLatString($lonlat)
    {
        if(empty($lonlat)) {
            throw new \InvalidArgumentException(sprintf('String "%s" could not be converted to GeoPoint', $lonlat));
        }

        list ($lon, $lat) = array_map('trim', explode(',', $lonlat));

        $lon = filter_var($lon, FILTER_VALIDATE_FLOAT);
        $lat = filter_var($lat, FILTER_VALIDATE_FLOAT);

        if (false === $lon || false === $lat) {
            throw new \InvalidArgumentException(sprintf('String "%s" could not be converted to GeoPoint', $lonlat));
        }

        return new self($lat, $lon);
    }

    public static function createFromLonLat($longitude, $latitude)
    {
        $longitude = filter_var($longitude, FILTER_VALIDATE_FLOAT);
        $latitude = filter_var($latitude, FILTER_VALIDATE_FLOAT);

        if (false === $longitude || false === $latitude) {
            throw new \InvalidArgumentException("Lon '$longitude' or Lat '$latitude' is not valid");
        }

        return new self($latitude, $longitude);
    }

    private function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLonLatString()
    {
        return $this->longitude . ',' . $this->latitude;
    }

    public function getLonLatStringYandex()
    {
        return $this->latitude . ',' . $this->longitude;
    }

    public function getLonLatArray()
    {
        return [$this->longitude, $this->latitude];
    }

    public function __toString()
    {
        return $this->getLonLatString();
    }
}
