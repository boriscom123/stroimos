<?php

namespace AppBundle\Entity;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Amg\Bundle\AdminBundle\Model\LockableEntityTrait;
use Amg\Bundle\TagBundle\Model\TagsTrait;
use Amg\DataCore\Model\Addressable\AddressableTrait;
use Amg\DataCore\Model\CategorizedTrait;
use Amg\DataCore\Model\Commentable\CommentableTrait;
use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Lead\LeadTrait;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Metadata\MetadataTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\PublishableInRss\PublishableInRssInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodTrait;
use Amg\DataCore\Model\RelevantNewsShown\RelevantNewsShownInterface;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Entity\Embeddable\Address;
use AppBundle\Model\AttachmentsTrait;
use AppBundle\Model\AuthorAndSourceTrait;
use AppBundle\Model\FullOfFlagsTrait;
use AppBundle\Model\HeroImageTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\MediaImageInterface;
use AppBundle\Model\MobileContentfulInterface;
use AppBundle\Model\MobileContentfulTrait;
use AppBundle\Model\MultiOwner;
use AppBundle\Model\MultiOwnerTrait;
use AppBundle\Model\PriorityPosition\PriorityPositionInterface;
use AppBundle\Model\PriorityPosition\PriorityPositionTrait;
use AppBundle\Model\RelatedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post
 *
 * @ORM\Table(indexes={
 *     @ORM\Index(name="publish_start_date_idx", columns={"publish_start_date"}),
 *     @ORM\Index(name="deleted", columns={"deleted_at"}),
 *     @ORM\Index(name="IDX_p_psd_ped", columns={"publishable", "publish_start_date", "publish_end_date", "id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PostRepository")
 */
class Post implements
    IdentifiableInterface,
    EntitledInterface,
    TeasingInterface,
    MetadataInterface,
    PublishableInterface,
    PublishingPeriodInterface,
    PublishableInRssInterface,
    RelevantNewsShownInterface,
    PriorityPositionInterface,
    LockableEntity,
    MediaImageInterface,
    MultiOwner,
    MobileContentfulInterface
{
    use EntitledTrait,
        TeasingTrait,
        LeadTrait,
        ContentfulTrait,
        MetadataTrait,
        ImageTrait,
        HeroImageTrait,
        AuthorAndSourceTrait,
        AttachmentsTrait,
        CategorizedTrait,
        RelatedTrait,
        TagsTrait,
        PublishableTrait,
        PublishingPeriodTrait,
        FullOfFlagsTrait,
        AddressableTrait,
        TimestampableTrait,
        CommentableTrait,
        ORMBehaviors\Blameable\Blameable,
        PriorityPositionTrait,
        LockableEntityTrait,
        MultiOwnerTrait,
        MobileContentfulTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Rubric[]|ArrayCollection $rubrics
     *
     * @ORM\ManyToMany(targetEntity="Rubric", cascade={"persist"})
     */
    protected $rubrics;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     *
     * "@deprecated
     */
    protected $popularised = false;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    protected $forRss = false;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    protected $forYaZenRss = false;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    protected $wordIsSmallRss = false;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    protected $inTop = false;
    protected $inTopOrder = false;

    /**
     * @var PostViews
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\PostViews", mappedBy="post", orphanRemoval=true)
     */
    protected $views;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=false)
     * @Gedmo\Slug(fields={"title"}, updatable=false, unique=false)
     * @Assert\Regex(
     *     pattern="/^[a-zA-z_0-9-]+$/",
     *     message="Поле может содержать только цифры и латинские буквы, а также знаки дефиса и подчеркивания"
     * )
     */
    protected $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    protected $publishDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="time")
     */
    protected $publishTime;

    /**
     * @var Author
     *
     * @ORM\ManyToOne(targetEntity="Author", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $journalistWriter;

    /**
     * @var Author
     *
     * @ORM\ManyToOne(targetEntity="Author", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $editor;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\AdministrativeArea")
     * @ORM\JoinTable(name="posts_administrative_areas",
     *     joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="administrative_area_id", referencedColumnName="id")}
     *     )
     */
    protected $administrativeAreas;

    /**
     * @var CityDistrict[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\CityDistrict")
     * @ORM\JoinTable(name="posts_areas",
     *     joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="city_district_id", referencedColumnName="id")}
     *     )
     */
    protected $cityDistricts;

    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="text", nullable=true)
     */
    protected $wordIsSmallContent = null;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt = null;


    public function __construct()
    {
        $this->setPublishStartDate(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Rubric[]|ArrayCollection
     */
    public function getRubrics()
    {
        return $this->rubrics ?: $this->rubrics = new ArrayCollection();
    }

    /**
     * @param Rubric[]|ArrayCollection $rubrics
     * @return $this
     */
    public function setRubrics($rubrics)
    {
        $this->rubrics = $rubrics;

        return $this;
    }

    public function addRubric(Rubric $rubric)
    {
        $this->getRubrics()->add($rubric);
    }

    public function __toString()
    {
        $string = $this->getPublishStartDate() ? $this->getPublishStartDate()->format("(Y m d H:i) ") : '';
        $string .= $this->getTitle() ?: '(публикация без названия)';

        return $string;
    }

    /**
     * @return boolean
     * @deprecated
     */
    public function isPopularised()
    {
        return $this->popularised;
    }

    /**
     * @param boolean $popularised
     * @return $this
     * @deprecated
     */
    public function setPopularised($popularised)
    {
        $this->popularised = $popularised;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isForRss()
    {
        return $this->forRss;
    }

    /**
     * @param boolean $forRss
     */
    public function setForRss($forRss)
    {
        $this->forRss = $forRss;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * @param string $publishDate
     * @return $this
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getPublishTime()
    {
        return $this->publishTime;
    }

    /**
     * @param string $publishTime
     * @return $this
     */
    public function setPublishTime($publishTime)
    {
        $this->publishTime = $publishTime;

        return $this;
    }

    public function getAddressText()
    {
        $address = $this->getAddress();

        return $address instanceof Address ? $address->getText() : '';
    }

    public function setPublishStartDate(\DateTime $publishStartDate = null)
    {
        $this->publishStartDate = $publishStartDate;
        $this->publishDate = $publishStartDate;
        $this->publishTime = $publishStartDate;
    }

    public function getAllRelatedConstruction()
    {
        return array_merge(
            $this->getRelatedConstructions()->toArray(),
            $this->getRelatedMetroStations()->toArray(),
            $this->getRelatedRoads()->toArray()
        );
    }

    /**
     * @return boolean
     */
    public function isInTop()
    {
        return $this->inTop;
    }

    /**
     * @param boolean $inTop
     */
    public function setInTop($inTop)
    {
        $this->inTop = $inTop;
    }

    /**
     * @return bool
     */
    public function isForYaZenRss()
    {
        return $this->forYaZenRss;
    }

    /**
     * @param bool $forYaZenRss
     */
    public function setForYaZenRss($forYaZenRss)
    {
        $this->forYaZenRss = $forYaZenRss;
    }

    /**
     * @return bool
     */
    public function isSubordinatePublication()
    {
        return (count($this->getOwners()) > 1 && $this->getCategory()->getAlias() !== Category::CATEGORY_PRESS_RELEASE);
    }

    /**
     * @return Author
     */
    public function getJournalistWriter()
    {
        return $this->journalistWriter;
    }

    /**
     * @param Author $journalistWriter
     * @return $this
     */
    public function setJournalistWriter($journalistWriter)
    {
        $this->journalistWriter = $journalistWriter;
        return $this;
    }

    /**
     * @return CityDistrict[]
     */
    public function getCityDistricts()
    {
        return $this->cityDistricts;
    }

    /**
     * @return mixed
     */
    public function getAdministrativeAreas()
    {
        return $this->administrativeAreas;
    }

    /**
     * @param CityDistrict[] $cityDistricts
     */
    public function setCityDistricts($cityDistricts)
    {
        $this->cityDistricts = $cityDistricts;
    }

    /**
     * @param mixed $administrativeAreas
     */
    public function setAdministrativeAreas($administrativeAreas)
    {
        $this->administrativeAreas = $administrativeAreas;
    }

    /**
     * @return bool
     */
    public function isWordIsSmallRss()
    {
        return $this->wordIsSmallRss;
    }

    /**
     * @param bool $wordIsSmallRss
     */
    public function setWordIsSmallRss($wordIsSmallRss)
    {
        $this->wordIsSmallRss = $wordIsSmallRss;
    }

    /**
     * @param string $wordIsSmallContent
     */
    public function setWordIsSmallContent($wordIsSmallContent)
    {
        $this->wordIsSmallContent = $wordIsSmallContent;
    }

    /**
     * @return string
     */
    public function getWordIsSmallContent()
    {
        return $this->wordIsSmallContent;
    }
    /**
     * @return Author
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * @param Author $editor
     */
    public function setEditor($editor)
    {
        $this->editor = $editor;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->publishable = false;
        $this->deletedAt = $deletedAt;
    }

    public function restore() {
        $this->deletedAt = null;
    }

    public function isInTrash()
    {
        return $this->deletedAt !== null;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    protected $publishStartDate;
}
