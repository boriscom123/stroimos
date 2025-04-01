<?php

namespace AppBundle\Entity;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Amg\Bundle\AdminBundle\Model\LockableEntityTrait;
use Amg\Bundle\TagBundle\Model\TagsTrait;
use Amg\DataCore\Model\Commentable\CommentableTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Metadata\MetadataTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\PublishableInRss\PublishableInRssInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodTrait;
use Amg\DataCore\Model\RelevantNewsShown\RelevantNewsShownInterface;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Model\AuthorAndSourceTrait;
use AppBundle\Model\FullOfFlagsTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\MediaImageInterface;
use AppBundle\Model\MultiOwner;
use AppBundle\Model\MultiOwnerTrait;
use AppBundle\Model\RelatedTrait;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Video
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\VideoRepository")
 */
class Video implements
    EntitledInterface,
    PublishableInterface,
    PublishingPeriodInterface,
    PublishableInRssInterface,
    RelevantNewsShownInterface,
    MetadataInterface,
    LockableEntity,
    MediaImageInterface,
    MultiOwner
{
    use EntitledTrait,
        MetadataTrait,
        ImageTrait,
        RelatedTrait,
        TagsTrait,
        PublishableTrait,
        PublishingPeriodTrait,
        FullOfFlagsTrait,
        TimestampableTrait,
        CommentableTrait,
        ORMBehaviors\Blameable\Blameable,
        LockableEntityTrait,
        MultiOwnerTrait,
        AuthorAndSourceTrait;

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
    protected $video;

    /**
     * @var Rubric[]|ArrayCollection $rubrics
     *
     * @ORM\ManyToMany(targetEntity="Rubric", cascade={"persist"})
     */
    protected $rubrics;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $isVisibleInVideoCategory = false;

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
     * @return Media
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param Media $video
     * @return $this
     */
    public function setVideo(Media $video = null)
    {
        $this->video = $video;
        return $this;
    }
    /**
     * @return bool
     */
    public function getIsVisibleInVideoCategory()
    {
        return $this->isVisibleInVideoCategory;
    }

    /**
     * @param boolean $isVisibleInVideoCategory
     * @return $this
     */
    public function setIsVisibleInVideoCategory($isVisibleInVideoCategory)
    {
        $this->isVisibleInVideoCategory = $isVisibleInVideoCategory;
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
        return $this->getTitle() ?: '(видеофайл без названия)';
    }
}

