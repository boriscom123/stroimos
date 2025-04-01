<?php

namespace ExtraBundle\Entity;

use Amg\DataCore\Model\Commentable\CommentableTrait;
use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Metadata\MetadataTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Model\RelatedTrait;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Initiative
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Initiative implements
    EntitledInterface,
    TeasingInterface,
    MetadataInterface,
    PublishableInterface
{
    use EntitledTrait,
        TeasingTrait,
        ContentfulTrait,
        MetadataTrait,
        RelatedTrait,
        PublishableTrait,
        TimestampableTrait,
        CommentableTrait,
        ORMBehaviors\Blameable\Blameable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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

    public function __toString()
    {
        return $this->getTitle() ?: '(без названия)';
    }
}
