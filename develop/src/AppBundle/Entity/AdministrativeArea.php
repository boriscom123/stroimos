<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\AdministrativeUnit\AdministrativeUnitInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AdministrativeArea extends AdministrativeUnit implements AdministrativeUnitInterface
{
    /**
     * @var boolean
     *
     * @Doctrine\ORM\Mapping\Column(name="publishable", type="boolean", options={"default" : 1})
     */
    protected $publishable = true;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $abbreviation;

    /**
     * @var CityDistrict[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CityDistrict", mappedBy="parent")
     */
    private $districts;

    /**
     * @var MultiPolygon
     * @ORM\Column(type="multipolygon", nullable=true)
     */
    private $polygon;


    /**
     * @return string
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * @return CityDistrict[]|ArrayCollection
     */
    public function getDistricts()
    {
        return $this->districts;
    }

    /**
     * @param CityDistrict[]|ArrayCollection $districts
     *
     * @return AdministrativeArea
     */
    public function setDistricts($districts)
    {
        $this->districts = $districts;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle() ?: '(неназванный административный округ)';
    }

    /**
     * @return AdministrativeArea
     */
    public function getAdministrativeArea()
    {
        return $this;
    }

    /**
     * @return CityDistrict|null
     */
    public function getCityDistrict()
    {
        return null;
    }

    public function getDisplayTitle()
    {
        return $this->getAbbreviation();
    }

    /**
     * @return MultiPolygon
     */
    public function getPolygon()
    {
        return $this->polygon;
    }

    /**
     * @param MultiPolygon $polygon
     */
    public function setPolygon($polygon)
    {
        $this->polygon = $polygon;
    }


    /**
     * @return bool
     */
    public function isPublishable()
    {
        return $this->publishable;
    }

    /**
     * @return bool
     */
    public function setPublishable($publishable)
    {
        $this->publishable = $publishable;
    }
}
