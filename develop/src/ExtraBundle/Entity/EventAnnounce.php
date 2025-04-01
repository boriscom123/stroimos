<?php

namespace ExtraBundle\Entity;

use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EventAnnounce
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 */
class EventAnnounce
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_SENT = 'sent';

    public static $statusLabels = [
        self::STATUS_NEW => 'формируется',
        self::STATUS_IN_PROGRESS => 'отправка запущена',
        self::STATUS_SENT => 'отправка завершена',
    ];

    use EntitledTrait,
        ContentfulTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="homepage", type="boolean")
     *
     * @Assert\Expression(
     *     "!this.getHomepage() or this.getEvent().isPublishable()",
     *     message="Анонс можно опубликовать на главной странице только если мероприятие опубликовано"
     * )
     */
    private $homepage = false;

    /**
     * @var Event
     *
     * @ORM\ManyToOne(targetEntity="ExtraBundle\Entity\Event")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    protected $event;

    /**
     * @var string
     * @ORM\Column(type="string", length=16)
     */
    private $status = self::STATUS_NEW;

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
     * Set homepage
     *
     * @param boolean $homepage
     *
     * @return EventAnnounce
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * Get homepage
     *
     * @return boolean
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     * @return $this
     */
    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
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
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatusLabel()
    {
        return self::$statusLabels[$this->getStatus()];
    }

    public function __toString()
    {
        return $this->title ?: '(без названия)';
    }
}

