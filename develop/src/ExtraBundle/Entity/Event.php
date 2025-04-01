<?php

namespace ExtraBundle\Entity;

use Amg\DataCore\Model\Addressable\AddressableTrait;
use Amg\DataCore\Model\Contentful\ContentfulInterface;
use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Metadata\MetadataTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodTrait;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Event implements
    EntitledInterface,
    PublishableInterface,
    PublishingPeriodInterface,
    MetadataInterface,
    TeasingInterface,
    ContentfulInterface
{
    const STATE_AWAIT = 0;
    const STATE_OPENED = 1;
    const STATE_CLOSED = 2;

    public static $states = [
        self::STATE_AWAIT => 'Ожидает открытия',
        self::STATE_OPENED => 'Открыто',
        self::STATE_CLOSED => 'Закрыто',
    ];

    use EntitledTrait,
        TeasingTrait,
        MetadataTrait,
        PublishableTrait,
        PublishingPeriodTrait,
        ContentfulTrait,
        TimestampableTrait,
        AddressableTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var User[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Sonata\UserBundle\Entity\User")
     */
    private $guests;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $videoPlayerCode;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $open = false;

    /**
     * @var EventAttachment[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ExtraBundle\Entity\EventAttachment", mappedBy="event", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $attachments;

    /**
     * @var VipEventAttachment[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ExtraBundle\Entity\VipEventAttachment", mappedBy="event", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $vipAttachments;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $state = self::STATE_AWAIT;

    public function __construct()
    {
        $this->publishStartDate = new \DateTime();
        $this->guests = new ArrayCollection();
        $this->attachments = new ArrayCollection();
        $this->vipAttachments = new ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return User[]|ArrayCollection
     */
    public function getGuests()
    {
        return $this->guests;
    }

    /**
     * @param User[]|ArrayCollection $guests
     * @return $this
     */
    public function setGuests($guests)
    {
        $this->guests = $guests;
        return $this;
    }

    /**
     * @return string
     */
    public function getVideoPlayerCode()
    {
        return $this->videoPlayerCode;
    }

    /**
     * @param string $videoPlayerCode
     * @return $this
     */
    public function setVideoPlayerCode($videoPlayerCode)
    {
        $this->videoPlayerCode = $videoPlayerCode;
        return $this;
    }

    /**
     * @param EventAttachment[] $attachments
     *
     * @return $this
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        foreach ($attachments as $attachment) {
            $attachment->setEvent($this);
        }

        return $this;
    }

    /**
     * @return EventAttachment|ArrayCollection
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    public function addAttachment(EventAttachment $attachment)
    {
        $attachment->setEvent($this);
        $this->attachments->add($attachment);
    }

    /**
     * @param VipEventAttachment[] $vipAttachments
     *
     * @return $this
     */
    public function setVipAttachments($vipAttachments)
    {
        $this->vipAttachments = $vipAttachments;

        foreach ($vipAttachments as $attachment) {
            $attachment->setEvent($this);
        }

        return $this;
    }

    /**
     * @return VipEventAttachment|ArrayCollection
     */
    public function getVipAttachments()
    {
        return $this->vipAttachments = $this->vipAttachments ?: new ArrayCollection();
    }

    public function addVipAttachment(VipEventAttachment $vipAttachments)
    {
        $vipAttachments->setEvent($this);
        $this->vipAttachments->add($vipAttachments);
    }

    /**
     * @return boolean
     */
    public function isOpen()
    {
        return $this->open;
    }

    /**
     * @param boolean $open
     * @return $this
     */
    public function setOpen($open)
    {
        $this->open = $open;
        return $this;
    }

    public function __toString()
    {
        return $this->title ?: '(без названия)';
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
}

