<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Entity\Embeddable\RoadType;
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
use AppBundle\Model\PriorityPosition\PriorityPositionInterface;
use AppBundle\Model\PriorityPosition\PriorityPositionTrait;
use AppBundle\Model\ValueObject\FunctionalPurpose;
use AppBundle\Search\SearchDataInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="\AppBundle\Entity\Repository\RoadRepository")
 * @Serializer\ExclusionPolicy("ALL")
 * @Serializer\AccessorOrder("custom", custom = {"id", "func", "status", "name", "address", "coords", "distance"})
 */
class Road implements
    ConstructionObjectInterface,
    PublishableInterface,
    PriorityPositionInterface,
    SearchDataInterface,
    MediaImageInterface,
    CoordinatesInterface,
    MetadataInterface,
    MobileContentfulInterface
{
    use IdentifiableTrait,
        ConstructionObjectTrait,
        ImageTrait,
        TeasingTrait,
        ContentfulTrait,
        PublishableTrait,
        CurrentlyTrait,
        PriorityPositionTrait,
        PanoramaTrait,
        TimestampableTrait,
        ExtraInformationTrait,
        MobileContentfulTrait,
        AssociationManagerTrait
    ;

    /**
     * @var RoadType
     *
     * @ORM\Embedded(class="\AppBundle\Entity\Embeddable\RoadType")
     */
    private $roadType;


    /**
     * @var RoadParameterValue[]|ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\RoadParameterValue",
     *     mappedBy="road",
     *     cascade={"persist","remove"},
     *     orphanRemoval=true
     * )
     */
    private $roadParameterValues;

    /**
     * @var Gallery[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Gallery", mappedBy="relatedRoads")
     */
    protected $relatedGalleries;

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
        return FunctionalPurpose::create(FunctionalPurpose::OBJ_FUNC__ROAD);
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("road_type")
     * @Serializer\Groups({"api"})
     * @Serializer\Type("string")

     * @return RoadType
     */
    public function getRoadType()
    {
        return $this->roadType;
    }

    /**
     * @param RoadType $type
     *
     * @return Road
     */
    public function setRoadType(RoadType $type)
    {
        $this->roadType = $type;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle() ?: '(неназванный дорожный объект)';
    }

    public function getSearchData()
    {
        return $this->getTitle() . ' ' .
            $this->getRoadType()->getLabel();
    }

    public function getMetaDescription()
    {

    }

    public function getMetaKeywords()
    {

    }

    public function getConstructionFunctional()
    {
        return 'road';
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
            $gallery->addRelatedRoads($this);
        }

        foreach ($galleriesToDel as $gallery) {
            $gallery->removeRelatedRoads($this);
        }

        $this->relatedGalleries = $relatedGalleries;
    }

    /**
     * @return RoadParameterValue[]|ArrayCollection
     */
    public function getRoadParameterValues()
    {
        return $this->roadParameterValues;
    }

    /**
     * @param RoadParameterValue[]|ArrayCollection $roadParameterValues
     */
    public function setRoadParameterValues($roadParameterValues)
    {
        $this->roadParameterValues = $roadParameterValues;
    }

    /**
     * @param RoadParameterValue $value
     * @return $this
     */
    public function addRoadParameterValue(RoadParameterValue $value)
    {
        $value->setRoad($this);
        $this->getRoadParameterValues()->add($value);

        return $this;
    }

    /**
     * @param RoadParameterValue $value
     * @return $this
     */
    public function removeRoadParameterValue(RoadParameterValue $value)
    {
        $this->getRoadParameterValues()->removeElement($value);

        return $this;
    }


}
