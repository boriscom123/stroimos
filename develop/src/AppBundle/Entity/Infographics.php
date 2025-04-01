<?php

namespace AppBundle\Entity;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Amg\Bundle\AdminBundle\Model\LockableEntityTrait;
use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Lead\LeadTrait;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Metadata\MetadataTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodTrait;
use Amg\DataCore\Model\RelevantNewsShown\RelevantNewsShownInterface;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Model\AuthorAndSourceTrait;
use AppBundle\Model\FullOfFlagsTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\MediaImageInterface;
use AppBundle\Model\PriorityPosition\PriorityPositionInterface;
use AppBundle\Model\PriorityPosition\PriorityPositionTrait;
use AppBundle\Model\RelatedTrait;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Infographics
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\InfographicsRepository")
 */
class Infographics implements
    EntitledInterface,
    TeasingInterface,
    MetadataInterface,
    PublishableInterface,
    PublishingPeriodInterface,

    RelevantNewsShownInterface,
    PriorityPositionInterface,
    LockableEntity,
    MediaImageInterface
{
    use EntitledTrait,
        TeasingTrait,
        LeadTrait,
        ContentfulTrait,
        MetadataTrait,
        ImageTrait,
        AuthorAndSourceTrait,
        RelatedTrait,
        \Amg\Bundle\TagBundle\Model\TagsTrait,
        PublishableTrait,
        PublishingPeriodTrait,
        FullOfFlagsTrait,
        TimestampableTrait,
        ORMBehaviors\Blameable\Blameable,
        PriorityPositionTrait,
        LockableEntityTrait;

    const TYPE_INFOGRAPHICS = 'infographics';
    const TYPE_STATISTICS = 'statistics';

    public static $typeLabels = [
        self::TYPE_INFOGRAPHICS => 'Инфографика',
        self::TYPE_STATISTICS => 'Статистика',
    ];

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     */
    protected $infographics;

    /**
     * @var string
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    protected $type = self::TYPE_INFOGRAPHICS;

    /**
     * @var Rubric[]|ArrayCollection $rubrics
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Rubric", cascade={"persist"})
     */
    protected $rubrics;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=false)
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     * @Assert\Regex(
     *     pattern="/^[a-zA-z_0-9-]+$/",
     *     message="Поле может содержать только цифры и латинские буквы, а также знаки дефиса и подчеркивания"
     * )
     */
    protected $slug;

    /**
     * @var boolean
     * @ORM\Column(name="is_visible_on_homepage", type="boolean",  options={"default" : true})
     */
    protected $isVisibleOnHomepage = true;

    public function __construct()
    {
        $this->publishStartDate = new \DateTime();
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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Infographics
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Media
     */
    public function getInfographics()
    {
        return $this->infographics;
    }

    /**
     * @param Media $infographics
     *
     * @return $this
     */
    public function setInfographics(Media $infographics = null)
    {
        $this->infographics = $infographics;

        return $this;
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
        return $this->getTitle() ?: '(инфографика без названия)';
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

    /**
     * @return bool
     */
    public function isVisibleOnHomepage()
    {
        return $this->isVisibleOnHomepage;
    }

    /**
     * @param bool $isVisibleOnHomepage
     */
    public function setIsVisibleOnHomepage($isVisibleOnHomepage)
    {
        $this->isVisibleOnHomepage = $isVisibleOnHomepage;
    }
}
