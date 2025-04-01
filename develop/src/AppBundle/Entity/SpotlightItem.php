<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="\AppBundle\Entity\Repository\SpotlightItemRepository")
 * @Gedmo\Loggable
 * @ORM\HasLifecycleCallbacks()
 */
class SpotlightItem
{
    use IdentifiableTrait;

    const LIMIT = 19;

    const LINK_TYPE_URI = 'uri';
    const LINK_TYPE_NEWS = 'post';
    const LINK_TYPE_PAGE = 'page';
    const LINK_TYPE_GALLERY = 'gallery';
    const LINK_TYPE_VIDEO = 'video';
    const LINK_TYPE_INFOGRAPHICS = 'infographics';
    const LINK_TYPE_CONSTRUCTION = 'construction';
    const LINK_TYPE_METRO = 'metro';
    const LINK_TYPE_ROAD = 'road';

    public static $linkTypeTitles = [
        self::LINK_TYPE_URI => 'Прямая ссылка',
        self::LINK_TYPE_NEWS => 'Публикация',
        self::LINK_TYPE_PAGE => 'Страница',
        self::LINK_TYPE_GALLERY => 'Фотогалерея',
        self::LINK_TYPE_VIDEO => 'Видео',
        self::LINK_TYPE_INFOGRAPHICS => 'Инфографика',
        self::LINK_TYPE_CONSTRUCTION => 'Объект строительства',
        self::LINK_TYPE_METRO => 'Метро',
        self::LINK_TYPE_ROAD => 'Дорожный объект',
    ];

    public static $linkTypeFields = [
        self::LINK_TYPE_URI => ['title', 'uri', 'openInNewTab', 'image'],
        self::LINK_TYPE_NEWS => [self::LINK_TYPE_NEWS, 'image'],
        self::LINK_TYPE_PAGE => [self::LINK_TYPE_PAGE, 'image'],
        self::LINK_TYPE_GALLERY => [self::LINK_TYPE_GALLERY, 'image'],
        self::LINK_TYPE_VIDEO => [self::LINK_TYPE_VIDEO, 'image'],
        self::LINK_TYPE_INFOGRAPHICS => [self::LINK_TYPE_INFOGRAPHICS, 'image'],
        self::LINK_TYPE_CONSTRUCTION => [self::LINK_TYPE_CONSTRUCTION, 'image'],
        self::LINK_TYPE_METRO => [self::LINK_TYPE_METRO, 'image'],
        self::LINK_TYPE_ROAD => [self::LINK_TYPE_ROAD, 'image'],
    ];

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Url(message="Невалидная ссылка")
     */
    private $uri;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $openInNewTab;

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     */
    private $image;

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     */
    private $carouselImage1;

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     */
    private $carouselImage2;

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     */
    private $carouselImage3;

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     */
    private $carouselImage4;

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     */
    private $carouselImage5;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     */
    private $type;

    /**
     * @var Post
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Post")
     */
    private $post;

    /**
     * @var Gallery
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Gallery")
     */
    private $gallery;

    /**
     * @var Video
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Video")
     */
    private $video;

    /**
     * @var Infographics
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Infographics")
     */
    private $infographics;

    /**
     * @var Construction
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Construction")
     */
    private $construction;

    /**
     * @var Construction
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\MetroStation")
     */
    private $metro;

    /**
     * @var Construction
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Road")
     */
    private $road;

    /**
     * @var Page
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Page")
     */
    private $page;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    private $position;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(type="string", nullable=true)
     */
    private $publicationType;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $backgroundImage;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return SpotlightItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     *
     * @return SpotlightItem
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isOpenInNewTab()
    {
        return $this->openInNewTab;
    }

    /**
     * @param boolean $openInNewTab
     *
     * @return SpotlightItem
     */
    public function setOpenInNewTab($openInNewTab)
    {
        $this->openInNewTab = $openInNewTab;

        return $this;
    }

    /**
     * @return Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Media $image
     *
     * @return SpotlightItem
     */
    public function setImage($image)
    {
        $this->image = $image;

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
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getType()
    {
        if (empty($this->type)) {
            foreach (self::$linkTypeFields as $type => $field) {
                $field = (array)$field;
                $fieldName = $field[0];
                if (!empty($this->$fieldName)) {
                    return $type;
                }
            }

            return self::LINK_TYPE_URI;
        }

        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return SpotlightItem
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     *
     * @return SpotlightItem
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param Gallery $gallery
     *
     * @return SpotlightItem
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @return Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param Video $video
     *
     * @return SpotlightItem
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return Infographics
     */
    public function getInfographics()
    {
        return $this->infographics;
    }

    /**
     * @param Infographics $infographics
     *
     * @return SpotlightItem
     */
    public function setInfographics($infographics)
    {
        $this->infographics = $infographics;

        return $this;
    }

    /**
     * @return Construction
     */
    public function getConstruction()
    {
        return $this->construction;
    }

    /**
     * @param Construction $construction
     *
     * @return SpotlightItem
     */
    public function setConstruction($construction)
    {
        $this->construction = $construction;

        return $this;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param Page $page
     *
     * @return SpotlightItem
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return Construction
     */
    public function getMetro()
    {
        return $this->metro;
    }

    /**
     * @param Construction $metro
     *
     * @return SpotlightItem
     */
    public function setMetro($metro)
    {
        $this->metro = $metro;

        return $this;
    }

    /**
     * @return Construction
     */
    public function getRoad()
    {
        return $this->road;
    }

    /**
     * @param Construction $road
     *
     * @return SpotlightItem
     */
    public function setRoad($road)
    {
        $this->road = $road;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return SpotlightItem
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    public function __toString()
    {
        $type = $this->getType();

        return (string)($this->getType() === self::LINK_TYPE_URI ? $this->getTitle() : (null !== $this->{$type} ? $this->{$type}->getTitle() : '(пустой элемент)'));
    }

    /**
     * @Assert\Callback
     * @param \Symfony\Component\Validator\Context\ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        $type = $this->getType();
        if ($type === self::LINK_TYPE_URI) {
            if (empty($this->getUri())) {
                $context->buildViolation('Отсутствует ссылка')->atPath('uri')->addViolation();
            }
            if (empty($this->getTitle())) {
                $context->buildViolation('Отсутствует текст ссылки')->atPath('title')->addViolation();
            }
        } else {
            if (null === $this->$type) {
                $context->buildViolation(sprintf('Не выбрана публикация'))->atPath($type)->addViolation();
            } elseif ($violation = $this->entityIsPublishedViolation()) {
                $context->buildViolation($violation)->atPath($type)->addViolation();
            }
        }
    }

    public function getTypeLabel()
    {
        return self::$linkTypeTitles[$this->getType()];
    }

    public function getEntity()
    {
        $type = $this->getType();

        if ($type === self::LINK_TYPE_URI) {
            return null;
        }

        return $this->$type;
    }

    public function getMaxPossiblePosition()
    {
        return self::LIMIT;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist()
    {
        if (empty($this->type)) {
            return;
        }

        foreach (self::$linkTypeFields as $type => $fields) {
            if ($this->type === $type) {
                continue;
            }

            foreach((array)$fields as $field) {
                $this->$field = null;
            }
        }
    }

    private function entityIsPublishedViolation()
    {
        $entity = $this->getEntity();
        if ($this->getEntity() instanceof PublishableInterface) {
            /** @var PublishableInterface $entity */
            if (!$entity->isPublishable()) {
                return 'Выбранная публикация не опубликована';
            }
        }
        if ($this->getEntity() instanceof PublishingPeriodInterface) {
            /** @var PublishingPeriodInterface $entity */
            $entity = $this->getEntity();
            $now = new \DateTime();
            if ($entity->getPublishStartDate() && $entity->getPublishStartDate() >= $now) {
                return 'Проверьте дату и время начала публикации';
            } elseif ($entity->getPublishEndDate() && $entity->getPublishEndDate() < $now) {
                return 'Проверьте дату и время окончания публикации';
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getPublicationType()
    {
        return $this->publicationType;
    }

    /**
     * @param string $publicationType
     */
    public function setPublicationType($publicationType)
    {
        $this->publicationType = $publicationType;
    }

    /**
     * @return bool
     */
    public function isBackgroundImage()
    {
        return $this->backgroundImage;
    }

    /**
     * @param bool $backgroundImage
     */
    public function setBackgroundImage($backgroundImage)
    {
        $this->backgroundImage = $backgroundImage;
    }

    /**
     * @return Media
     */
    public function getCarouselImage1()
    {
        return $this->carouselImage1;
    }

    /**
     * @param Media $carouselImage1
     */
    public function setCarouselImage1($carouselImage1)
    {
        $this->carouselImage1 = $carouselImage1;
    }


    public function hasCarouselImages() {
        if ($this->image) {
            return true;
        }
        for($i =1;$i<6;$i++) {
            $propName = "carouselImage{$i}";
            if ($this->$propName) {
                return true;
            }
        }
        $has = true;


        return false;
    }
    /**
     * @return Media
     */
    public function getCarouselImages()
    {
        return [
            $this->image,
            $this->carouselImage1,
            $this->carouselImage2,
            $this->carouselImage3,
            $this->carouselImage4,
            $this->carouselImage5,
        ];
    }

    /**
     * @return Media
     */
    public function getCarouselImage5()
    {
        return $this->carouselImage5;
    }

    /**
     * @param Media $carouselImage5
     */
    public function setCarouselImage5($carouselImage5)
    {
        $this->carouselImage5 = $carouselImage5;
    }

    /**
     * @return Media
     */
    public function getCarouselImage4()
    {
        return $this->carouselImage4;
    }

    /**
     * @param Media $carouselImage4
     */
    public function setCarouselImage4($carouselImage4)
    {
        $this->carouselImage4 = $carouselImage4;
    }

    /**
     * @return Media
     */
    public function getCarouselImage3()
    {
        return $this->carouselImage3;
    }

    /**
     * @param Media $carouselImage3
     */
    public function setCarouselImage3($carouselImage3)
    {
        $this->carouselImage3 = $carouselImage3;
    }

    /**
     * @return Media
     */
    public function getCarouselImage2()
    {
        return $this->carouselImage2;
    }

    /**
     * @param Media $carouselImage2
     */
    public function setCarouselImage2($carouselImage2)
    {
        $this->carouselImage2 = $carouselImage2;
    }


}
