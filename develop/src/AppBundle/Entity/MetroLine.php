<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;

use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use AppBundle\Model\AssociationManagerTrait;
use AppBundle\Model\ExtraInformationTrait;
use AppBundle\Model\MobileContentfulInterface;
use AppBundle\Model\MobileContentfulTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class MetroLine implements
    EntitledInterface,
    TeasingInterface,
    PublishableInterface,
    MetadataInterface,
    MobileContentfulInterface
{
    use IdentifiableTrait;
    use EntitledTrait;
    use TeasingTrait;
    use ContentfulTrait;
    use PublishableTrait;
    use MobileContentfulTrait;
    use AssociationManagerTrait;
    use ExtraInformationTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $color;

    /**
     * @var MetroStation[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MetroStation", mappedBy="line")
     */
    private $stations;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $number;

    /**
     * @var Gallery[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Gallery", inversedBy="relatedMetroLines")
     * @ORM\JoinTable(name="metrolines_galleries")
     */
    protected $relatedGalleries;

    public function __construct()
    {
        $this->stations = new ArrayCollection();
        $this->relatedGalleries = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     *
     * @return MetroLine
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return MetroStation[]
     */
    public function getStations()
    {
        return $this->stations;
    }

    /**
     * @param MetroStation[] $stations
     *
     * @return MetroLine
     */
    public function setStations($stations)
    {
        $this->stations = $stations;

        return $this;
    }

    /**
     * @param \AppBundle\Entity\MetroStation $station
     */
    public function addStation(MetroStation $station)
    {
        $this->stations->add($station);
    }

    public function __toString()
    {
        return $this->getTitle() ?: '(неназванная линия метро)';
    }

    public function getMetaDescription()
    {

    }

    public function getMetaKeywords()
    {

    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return Gallery[]|ArrayCollection
     */
    public function getRelatedGalleries()
    {
        return $this->relatedGalleries;
    }

    /**
     * @param Gallery[]|ArrayCollection $relatedGalleries
     */
    public function setRelatedGalleries($relatedGalleries)
    {
        $galleriesToAdd = $this->findNewEntitiesIn($relatedGalleries, $this->getRelatedGalleries());
        $galleriesToDel = $this->findMissingEntitiesIn($relatedGalleries, $this->getRelatedGalleries());


        foreach ($galleriesToAdd as $gallery) {
            $gallery->addRelatedMetroLine($this);
        }

        foreach ($galleriesToDel as $gallery) {
            $gallery->removeRelatedMetroLine($this);
        }

        $this->relatedGalleries = $relatedGalleries;
    }

}
