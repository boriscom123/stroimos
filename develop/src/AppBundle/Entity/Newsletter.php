<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Entity\EmbeddedContent\Quote;
use AppBundle\Entity\NewsletterItem\GalleryNewsletter;
use AppBundle\Entity\NewsletterItem\HighlightNewsletter;
use AppBundle\Entity\NewsletterItem\InfographicsNewsletter;
use AppBundle\Entity\NewsletterItem\PostNewsletter;
use AppBundle\Entity\NewsletterItem\VideoNewsletter;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\NewsletterRepository")
 */
class Newsletter
{
    use TimestampableTrait,
        ORMBehaviors\Blameable\Blameable;

    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_SENT = 'sent';

    const GALLERY_WALLPAPER_SELF_LOADED = 'self_loaded';
    const GALLERY_WALLPAPER_STATIC_IMAGE_FROM_GALLERY = 'static_image_from_gallery';
    const GALLERY_WALLPAPER_STATIC_ANIMATED_FROM_GALLERY = 'animated_image_from_gallery';

    public static $statusLabels = [
        self::STATUS_NEW => 'формируется',
        self::STATUS_IN_PROGRESS => 'отправка запущена',
        self::STATUS_SENT => 'отправка завершена',
    ];


    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", unique=true)
     */
    private $date;

    /**
     * @var integer
     * @ORM\Column(type="string", length=16)
     */
    private $status;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @var PostNewsletter[]|ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\NewsletterItem\PostNewsletter",
     *     mappedBy="newsletter",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     * @ORM\JoinTable(name="newsletter_posts")
     * @ORM\OrderBy({"priorityPosition" = "ASC"})
     */
    private $posts;

    /**
     * @var InfographicsNewsletter[]|ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\NewsletterItem\InfographicsNewsletter",
     *     mappedBy="newsletter",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     * @ORM\JoinTable(name="newsletter_infographics")
     * @ORM\OrderBy({"priorityPosition" = "ASC"})
     */
    private $infographicsNl;

    /**
     * @var GalleryNewsletter[]|ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\NewsletterItem\GalleryNewsletter",
     *     mappedBy="newsletter",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     * @ORM\JoinTable(name="newsletter_galleries")
     * @ORM\OrderBy({"priorityPosition" = "ASC"})
     */
    private $galleries;

    /**
     * @var VideoNewsletter[]|ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\NewsletterItem\VideoNewsletter",
     *     mappedBy="newsletter",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     * @ORM\JoinTable(name="newsletter_videos")
     * @ORM\OrderBy({"priorityPosition" = "ASC"})
     */
    private $videos;

    /**
     * @var Document|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Document")
     * @ORM\JoinTable(name="newsletter_documents")
     */
    private $documents;

    /**
     * @var Quote
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EmbeddedContent\Quote")
     * @ORM\JoinColumn()
     */
    protected $quote;

    /**
     * @var HighlightNewsletter
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\NewsletterItem\HighlightNewsletter")
     * @ORM\JoinColumn()
     */
    protected $highlight;

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     */
    protected $galleryWallpaper;

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     */
    protected $spotlightItemWallpaper;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $galleryWallpaperType;

    public function __construct()
    {
        $this->status = self::STATUS_NEW;
        $this->date = new \DateTime();
        $this->posts = new ArrayCollection();
        $this->infographicsNl = new ArrayCollection();
        $this->galleries = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Newsletter
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return Newsletter
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return PostNewsletter[]
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param PostNewsletter[]|ArrayCollection $posts
     * @return $this
     */
    public function setPosts($posts)
    {
        foreach ($posts as $post) {
            $this->addPost($post);
        }

        return $this;
    }

    public function getStatusLabel()
    {
        return self::$statusLabels[$this->getStatus()];
    }

    public function __toString()
    {
        return 'Рассылка от ' . $this->getDate()->format('d.m.Y');
    }

    /**
     * @return InfographicsNewsletter[]
     */
    public function getInfographicsNl()
    {
        return $this->infographicsNl;
    }

    /**
     * @param InfographicsNewsletter[] $infographicsNl
     * @return $this
     */
    public function setInfographicsNl($infographicsNl)
    {
        foreach ($infographicsNl as $infographic) {
            $this->addInfographicsNl($infographic);
        }

        return $this;
    }

    /**
     * @return GalleryNewsletter[]
     */
    public function getGalleries()
    {
        return $this->galleries;
    }

    /**
     * @param GalleryNewsletter[] $galleries
     * @return $this
     */
    public function setGalleries($galleries)
    {
        foreach ($galleries as $gallery) {
            $this->addGallery($gallery);
        }
        return $this;
    }

    /**
     * @return VideoNewsletter[]
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param VideoNewsletter $videos
     * @return $this
     */
    public function setVideos($videos)
    {
        foreach ($videos as $video) {
            $this->addVideo($video);
        }

        return $this;
    }

    /**
     * @return Document
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param Document $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }

    /**
     * @param $pn PostNewsletter
     * @return $this
     */
    public function addPost($pn)
    {
        $pn->setNewsletter($this);
        $this->posts->add($pn);

        return $this;
    }

    /**
     * @param $pn PostNewsletter
     * @return $this
     */
    public function removePost($pn)
    {
        $this->posts->removeElement($pn);

        return $this;
    }

    /**
     * @param $gn GalleryNewsletter
     * @return $this
     */
    public function addGallery($gn)
    {
        $gn->setNewsletter($this);
        $this->galleries->add($gn);

        return $this;
    }

    /**
     * @param $gn GalleryNewsletter
     * @return $this
     */
    public function removeGallery($gn)
    {
        $this->galleries->removeElement($gn);

        return $this;
    }

    /**
     * @param $vn VideoNewsletter
     * @return $this
     */
    public function addVideo($vn)
    {
        $vn->setNewsletter($this);
        $this->videos->add($vn);

        return $this;
    }

    /**
     * @param $vn VideoNewsletter
     * @return $this
     */
    public function removeVideo($vn)
    {
        $this->videos->removeElement($vn);

        return $this;
    }

    /**
     * @return Quote
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * @param Quote $quote
     * @return $this
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;

        return $this;
    }

    /**
     * @return HighlightNewsletter
     */
    public function getHighlight()
    {
        return $this->highlight;
    }

    /**
     * @param HighlightNewsletter $highlight
     * @return $this
     */
    public function setHighlight($highlight)
    {
        $this->highlight = $highlight;

        return $this;
    }

    /**
     * @param $in InfographicsNewsletter
     * @return $this
     */
    public function addInfographicsNl($in)
    {
        $in->setNewsletter($this);
        $this->infographicsNl->add($in);

        return $this;
    }

    /**
     * @param $in InfographicsNewsletter
     * @return $this
     */
    public function removeInfographicsNl($in)
    {
        $this->infographicsNl->removeElement($in);

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return Media
     */
    public function getGalleryWallpaper()
    {
        return $this->galleryWallpaper;
    }

    /**
     * @param Media $galleryWallpaper
     */
    public function setGalleryWallpaper($galleryWallpaper)
    {
        $this->galleryWallpaper = $galleryWallpaper;
    }

    /**
     * @return Media
     */
    public function getSpotlightItemWallpaper()
    {
        return $this->spotlightItemWallpaper;
    }

    /**
     * @param Media $spotlightItemWallpaper
     */
    public function setSpotlightItemWallpaper($spotlightItemWallpaper)
    {
        $this->spotlightItemWallpaper = $spotlightItemWallpaper;
    }

    /**
     * @return string
     */
    public function getGalleryWallpaperType()
    {
        return $this->galleryWallpaperType;
    }

    /**
     * @param string $galleryWallpaperType
     */
    public function setGalleryWallpaperType($galleryWallpaperType)
    {
        $isValid = in_array(
            $galleryWallpaperType,
            [
                self::GALLERY_WALLPAPER_STATIC_ANIMATED_FROM_GALLERY,
                self::GALLERY_WALLPAPER_SELF_LOADED,
                self::GALLERY_WALLPAPER_STATIC_IMAGE_FROM_GALLERY,
            ]
        );

        if (!$isValid) {
            throw new \InvalidArgumentException("Invalid type");
        }
        $this->galleryWallpaperType = $galleryWallpaperType;
    }

    public function personaliseFor(EmailSubscription $subscription)
    {
        $admUnitsInSubscription = $subscription->getAdministrativeUnits();

        $customPosts = [];
        foreach ($this->getPosts()->toArray() as $postInNewsletter) {
            $admAreas = $postInNewsletter->getPost()->getAdministrativeAreas()->toArray();
            $postCityDistricts = $postInNewsletter->getPost()->getCityDistricts()->toArray();
            if (empty($postCityDistricts) && empty($admAreas)) {
                $customPosts[] = $postInNewsletter;
                continue;
            }
            foreach ($admUnitsInSubscription as $admUnit) {
                $admUnitsInSubscriptionId = $admUnit->getId();
                foreach ($admAreas as $admArea) {
                    if ($admUnitsInSubscriptionId === $admArea->getId()) {
                        $customPosts[] = $postInNewsletter;
                        break 2;
                    }
                }

                foreach ($postCityDistricts as $postCityDistrict) {
                    if ($admUnitsInSubscriptionId === $postCityDistrict->getId()) {
                        $customPosts[] = $postInNewsletter;
                        break 2;
                    }
                }
            }
        }

        $personalNewsletter = clone $this;
        $personalNewsletter->posts = new ArrayCollection($customPosts);

        return $personalNewsletter;
    }

    public function personaliseByGeneralPosts()
    {
        $generalPosts = [];
        foreach ($this->getPosts()->toArray() as $postInNewsletter) {
            $admArea = $postInNewsletter->getPost()->getAdministrativeAreas()->toArray();
            $postCityDistrict = $postInNewsletter->getPost()->getCityDistricts()->toArray();
            if (empty($postCityDistrict) && empty($admArea)) {
                $generalPosts[] = $postInNewsletter;
                continue;
            }
        }

        $personalNewsletter = clone $this;
        $personalNewsletter->posts = new ArrayCollection($generalPosts);

        return $personalNewsletter;
    }
}
