<?php

namespace AppBundle\Entity\NewsletterItem;

use Amg\DataCore\Model\Contentful\ContentfulInterface;
use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\LinkableInterface;
use AppBundle\Model\LinkableTrait;
use AppBundle\Model\MediaImageInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table()
 */
class HighlightNewsletter implements
    IdentifiableInterface,
    EntitledInterface,
    TeasingInterface,
    ContentfulInterface,
    MediaImageInterface,
    LinkableInterface
{
    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="string", length=255, nullable=true)
     */
    protected $title;

    use IdentifiableTrait,
        TeasingTrait,
        ContentfulTrait,
        ImageTrait,
        LinkableTrait;

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
     * @return string
     */
    public function __toString()
    {
        return $this->getTeaser();
    }
}
