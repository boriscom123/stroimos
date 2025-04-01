<?php

namespace AppBundle\Entity;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Amg\Bundle\AdminBundle\Model\LockableEntityTrait;
use Amg\Bundle\TagBundle\Model\TagsTrait;
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
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Model\FullOfFlagsTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\MediaImageInterface;
use AppBundle\Model\MultiOwner;
use AppBundle\Model\MultiOwnerTrait;
use AppBundle\Model\PriorityPosition\PriorityPositionInterface;
use AppBundle\Model\PriorityPosition\PriorityPositionTrait;
use AppBundle\Model\RelatedTrait;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * PhotoGallery
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\GalleryRepository")
 */
class Gallery implements
    EntitledInterface,
    TeasingInterface,
    PublishableInterface,
    PublishingPeriodInterface,
    PublishableInRssInterface,
    RelevantNewsShownInterface,
    PriorityPositionInterface,
    MetadataInterface,
    LockableEntity,
    MediaImageInterface,
    MultiOwner
{
    use EntitledTrait,
        TeasingTrait,
        MetadataTrait,
        ImageTrait,
        RelatedTrait,
        TagsTrait,
        PublishableTrait,
        PublishingPeriodTrait,
        FullOfFlagsTrait,
        TimestampableTrait,
        ORMBehaviors\Blameable\Blameable,
        PriorityPositionTrait,
        LockableEntityTrait,
        MultiOwnerTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var GalleryMedia[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="GalleryMedia", mappedBy="gallery", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $medias;

    /**
     * @var Rubric[]|ArrayCollection $rubrics
     *
     * @ORM\ManyToMany(targetEntity="Rubric", cascade={"persist"})
     */
    protected $rubrics;

    /**
     * @var boolean
     *
     * @Doctrine\ORM\Mapping\Column(type="boolean", options={"default" : false})
     */
    protected $hiddenFromGallery = false;


    /**
     * @var MetroLine[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\MetroLine", mappedBy="relatedGalleries")
     */
    protected $relatedMetroLines;

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     */
    protected $animatedWallpaper;

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
     * @return GalleryMedia[]|ArrayCollection
     */
    public function getMedias()
    {
        return $this->medias ?: $this->medias = new ArrayCollection();
    }

    /**
     * @param GalleryMedia[]|ArrayCollection $medias
     * @return $this
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;
        return $this;
    }

    /**
     * @param GalleryMedia $media
     * @return $this
     */
    public function addMedia(GalleryMedia $media)
    {
        $this->medias->add($media);
        $media->setGallery($this);
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

    public function __toString()
    {
        return (string) $this->getTitle();
    }

    public function addRubric(Rubric $rubric)
    {
        $this->getRubrics()->add($rubric);
    }

    /**
     * @return boolean
     */
    public function isHiddenFromGallery()
    {
        return $this->hiddenFromGallery;
    }

    /**
     * @param boolean $hiddenFromGallery
     * @return $this
     */
    public function setHiddenFromGallery($hiddenFromGallery)
    {
        $this->hiddenFromGallery = $hiddenFromGallery;

        return $this;
    }

    public function addRelatedMetroLine(MetroLine $metroLine)
    {
        $this->relatedMetroLines[] = $metroLine;
    }


    public function removeRelatedMetroLine(MetroLine $metroLine)
    {
        $this->relatedMetroLines->removeElement($metroLine);
    }

    /**
     * @return Media
     */
    public function getAnimatedWallpaper()
    {
        return $this->animatedWallpaper;
    }

    /**
     * @param Media $animatedWallpaper
     */
    public function setAnimatedWallpaper($animatedWallpaper)
    {
        $this->animatedWallpaper = $animatedWallpaper;
    }
}
