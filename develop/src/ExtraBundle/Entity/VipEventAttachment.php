<?php

namespace ExtraBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use AppBundle\Model\FileTrait;
use AppBundle\Model\PositionTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class VipEventAttachment implements EntitledInterface
{
    use FileTrait, PositionTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Event
     *
     * @ORM\ManyToOne(targetEntity="ExtraBundle\Entity\Event", inversedBy="vipAttachments")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $event;

    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="string", length=255)
     * @Assert\NotBlank(message="Заполните заголовок прикреплённого файла")
     */
    protected $title;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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

    public function __toString()
    {
        return (string) $this->getTitle() ?: '(без названия)';
    }
}
