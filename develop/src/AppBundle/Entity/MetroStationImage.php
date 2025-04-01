<?php

namespace AppBundle\Entity;

use Amg\Bundle\TagBundle\Model\TagsTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Metadata\MetadataTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Model\ImageTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class MetroStationImage implements
    EntitledInterface,
    TeasingInterface,
    PublishableInterface
{
    use TeasingTrait,
        MetadataTrait,
        ImageTrait,
        TagsTrait,
        PublishableTrait,
        TimestampableTrait,
        ORMBehaviors\Blameable\Blameable;

    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var MetroStation
     *
     * @ORM\ManyToOne(targetEntity="MetroStation", inversedBy="medias")
     */
    protected $metroStation;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $position = 0;

    public function __construct()
    {
        $this->setPublishable(true);
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

    public function setId($id)
    {
        return $this->id = $id;
    }

    /**
     * @return MetroStation
     */
    public function getMetroStation()
    {
        return $this->metroStation;
    }

    /**
     * @param MetroStation $metroStation
     *
     * @return MetroStationImage
     */
    public function setMetroStation(MetroStation $metroStation = null)
    {
        $this->metroStation = $metroStation;

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
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getTitle();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}
