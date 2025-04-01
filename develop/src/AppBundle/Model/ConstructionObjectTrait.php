<?php
namespace AppBundle\Model;

use Amg\DataCore\Model\Addressable\AddressableTrait;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use AppBundle\Entity\Embeddable\Address;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Entity\MetroStation;
use AppBundle\Model\ValueObject\GeoPoint;

trait ConstructionObjectTrait
{
    use EntityReferenceTrait;
    use EntitledTrait;
    use AddressableTrait;

    /**
     * @var ConstructionStatus
     * @ORM\Embedded(class="AppBundle\Entity\Embeddable\ConstructionStatus")
     */
    private $constructionStatus;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $constructionStatusDescription;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $constructionStartYear;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $constructionEndYear;

    protected $distance = null;

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("distance")
     * @Serializer\Groups({"api"})

     * @return float|null
     */
    public function getDistance()
    {
        return $this->distance;
    }

    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("status")
     * @Serializer\Groups({"api"})
     * @Serializer\Type("string")
     *
     * @return string
     */
    public function getConstructionStatus()
    {
        return $this->constructionStatus;
    }

    /**
     * @param \AppBundle\Entity\Embeddable\ConstructionStatus $constructionStatus
     *
     * @return MetroStation
     */
    public function setConstructionStatus($constructionStatus)
    {
        $this->constructionStatus = $constructionStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getConstructionStatusDescription()
    {
        return $this->constructionStatusDescription;
    }

    /**
     * @param string $constructionStatusDescription
     *
     * @return MetroStation
     */
    public function setConstructionStatusDescription($constructionStatusDescription)
    {
        $this->constructionStatusDescription = $constructionStatusDescription;

        return $this;
    }

    /**
     * @return int
     */
    public function getConstructionStartYear()
    {
        return $this->constructionStartYear;
    }

    /**
     * @param int $constructionStartYear
     *
     * @return MetroStation
     */
    public function setConstructionStartYear($constructionStartYear)
    {
        $this->constructionStartYear = $constructionStartYear;

        return $this;
    }

    /**
     * @return int
     */
    public function getConstructionEndYear()
    {
        return $this->constructionEndYear;
    }

    /**
     * @param int $constructionEndYear
     *
     * @return MetroStation
     */
    public function setConstructionEndYear($constructionEndYear)
    {
        $this->constructionEndYear = $constructionEndYear;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("address")
     * @Serializer\Groups({"api"})

     * @return string
     */
    public function getAddressText()
    {
        $address = $this->getAddress();

        return $address instanceof Address ? $address->getText() : '';
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("coords")
     * @Serializer\Groups({"api"})
     * @return array
     */
    public function getGeoPointCoordinatesInGeoJson()
    {
        $geoPoint = $this->getAddress()->getGeoPoint();
	    if ($geoPoint) {
		    return json_encode($geoPoint->getLonLatArray());
	    }

	    return json_encode(GeoPoint::createFromLonLatString('37.620393,55.75396')->getLonLatArray());
    }

    public function getGeoPointAsLonLatArray()
    {
        $address = $this->getAddress();

        if (!$address instanceof Address) {
            return null;
        }

        $geoPoint = $address->getGeoPoint();
        if (!$geoPoint instanceof GeoPoint) {
            return null;
        }

        return $geoPoint->getLonLatArray();
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("name")
     * @Serializer\Groups({"api"})

     * @return string
     */
    public function getObjectName()
    {
        return $this->getTitle();
    }

    public function getConstructionStatusTranslations()
    {
        return ConstructionStatus::$labels;
    }

    /**
     * @return string|null
     */
    public function getCoordinates()
    {
        if($this->getAddress() !== null && $this->getAddress()->getGeoPoint() !== null) {
            return $this->getAddress()->getGeoPoint()->getLonLatString();
        }

        return null;
    }
}

