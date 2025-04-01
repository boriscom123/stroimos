<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Model\AssociationManagerTrait;
use AppBundle\Model\ConstructionObjectInterface;
use AppBundle\Model\ConstructionObjectTrait;
use AppBundle\Model\CoordinatesInterface;
use AppBundle\Model\CurrentlyTrait;
use AppBundle\Model\ExtraInformationTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\MediaImageInterface;
use AppBundle\Model\MobileContentfulInterface;
use AppBundle\Model\MobileContentfulTrait;
use AppBundle\Model\PanoramaTrait;
use AppBundle\Model\ValueObject\FunctionalPurpose;
use AppBundle\Model\VideoTrait;
use AppBundle\Model\XYInterface;
use AppBundle\Model\XYTrait;
use AppBundle\Search\SearchDataInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="\AppBundle\Entity\Repository\MetroStationRepository")
 * @ORM\Embeddable
 * @Serializer\ExclusionPolicy("ALL")
 * @Serializer\AccessorOrder("custom", custom = {"id", "func", "status", "name", "address", "coords", "distance"})
 */
class MetroStation implements
    ConstructionObjectInterface,
    PublishableInterface,
    SearchDataInterface,
    MediaImageInterface,
    CoordinatesInterface,
    MetadataInterface,
    MobileContentfulInterface,
    XYInterface
{
    use IdentifiableTrait,
        ConstructionObjectTrait,
        ImageTrait,
        TeasingTrait,
        ContentfulTrait,
        PublishableTrait,
        CurrentlyTrait,
        VideoTrait,
        PanoramaTrait,
        TimestampableTrait,
        MobileContentfulTrait,
        XYTrait,
        AssociationManagerTrait,
        ExtraInformationTrait
    ;

    /**
     * @var MetroLine
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MetroLine", inversedBy="stations")
     */
    private $line;

    /**
     * @var MetroStationImage[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MetroStationImage", mappedBy="metroStation", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $medias;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $entranceHallDescription;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $featureDescription;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $capacityDescription;

    /**
     * @var Gallery[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Gallery", mappedBy="relatedMetroStations")
     */
    protected $relatedGalleries;

    /**
     * @return MetroLine
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param MetroLine $line
     *
     * @return MetroStation
     */
    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * @return MetroStationImage[]|ArrayCollection
     */
    public function getMedias()
    {
        return $this->medias ?: $this->medias = new ArrayCollection();
    }

    /**
     * @param MetroStationImage[]|ArrayCollection $images
     *
     * @return MetroStation
     */
    public function setMedias($images)
    {
        $this->medias = $images;

        return $this;
    }

    public function addMedia(MetroStationImage $media)
    {
        $this->medias->add($media);
        $media->setMetroStation($this);

        return $this;
    }

    /**
     * @return string
     */
    public function getEntranceHallDescription()
    {
        return $this->entranceHallDescription;
    }

    /**
     * @param string $entranceHallDescription
     *
     * @return MetroStation
     */
    public function setEntranceHallDescription($entranceHallDescription)
    {
        $this->entranceHallDescription = $entranceHallDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeatureDescription()
    {
        return $this->featureDescription;
    }

    /**
     * @param string $featureDescription
     *
     * @return MetroStation
     */
    public function setFeatureDescription($featureDescription)
    {
        $this->featureDescription = $featureDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getCapacityDescription()
    {
        return $this->capacityDescription;
    }

    /**
     * @param string $capacityDescription
     *
     * @return MetroStation
     */
    public function setCapacityDescription($capacityDescription)
    {
        $this->capacityDescription = $capacityDescription;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("func")
     * @Serializer\Groups({"api"})
     * @Serializer\Type("string")
     *
     * @return FunctionalPurpose
     */
    public function getFunctionalPurpose()
    {
        return FunctionalPurpose::create(FunctionalPurpose::OBJ_FUNC__METRO);
    }

    public function __toString()
    {
        return $this->getTitle() ?: '(неназванная станция метро)';
    }

    public function getConstructionStatusTranslations()
    {
        return array_merge(
            ConstructionStatus::$labels,
            [
                ConstructionStatus::OBJ_STATUS__OPERATION => 'открыта',
            ]
        );
    }

    public function getSearchData()
    {
        return $this->getTitle().' '.
            $this->getAddressText().' '.
            $this->getLine()->getTitle().' '.
            'метро';
    }

    public function getMetaDescription()
    {

    }

    public function getMetaKeywords()
    {

    }

    public function getConstructionFunctional()
    {
        return 'metro';
    }

    /**
     * @return Gallery[]|ArrayCollection
     */
    public function getRelatedGalleries()
    {
        return $this->relatedGalleries ?: $this->relatedGalleries = new ArrayCollection();
    }

    /**
     * @param Gallery[]|ArrayCollection $relatedGalleries
     */
    public function setRelatedGalleries($relatedGalleries)
    {
        $galleriesToAdd = $this->findNewEntitiesIn($relatedGalleries, $this->getRelatedGalleries());
        $galleriesToDel = $this->findMissingEntitiesIn($relatedGalleries, $this->getRelatedGalleries());


        foreach ($galleriesToAdd as $gallery) {
            $gallery->addRelatedMetroStations($this);
        }

        foreach ($galleriesToDel as $gallery) {
            $gallery->removeRelatedMetroStations($this);
        }

        $this->relatedGalleries = $relatedGalleries;
    }
}
