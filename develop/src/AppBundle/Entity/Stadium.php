<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\RelevantNewsShown\RelevantNewsShownInterface;
use Amg\DataCore\Model\RelevantNewsShown\RelevantNewsShownTrait;

use Amg\DataCore\Model\Searchable\SearchableTrait;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Entity\Embeddable\ConstructionData;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\RelatedTrait;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Stadium
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Stadium implements
    EntitledInterface,
    TeasingInterface,
    PublishableInterface,

    RelevantNewsShownInterface
{
    use EntitledTrait,
        TeasingTrait,
        ContentfulTrait,
        ImageTrait,
        RelatedTrait,
        \Amg\Bundle\TagBundle\Model\TagsTrait,
        PublishableTrait,
        SearchableTrait,
        RelevantNewsShownTrait,
        TimestampableTrait,
        ORMBehaviors\Blameable\Blameable;

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
    protected $tour3D;

    /**
     * @var ConstructionData
     *
     * @ORM\Embedded(class="AppBundle\Entity\Embeddable\ConstructionData")
     */
    protected $data;

    //todo: time to subway station

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
    public function getTour3D()
    {
        return $this->tour3D;
    }

    /**
     * @param Media $tour3D
     * @return $this
     */
    public function setTour3D(Media $tour3D = null)
    {
        $this->tour3D = $tour3D;
        return $this;
    }

    /**
     * @return ConstructionData
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param ConstructionData $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}

