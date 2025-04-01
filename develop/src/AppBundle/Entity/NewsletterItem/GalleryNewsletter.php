<?php

namespace AppBundle\Entity\NewsletterItem;

use AppBundle\Entity\Gallery;
use AppBundle\Entity\Newsletter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="newsletter_galleries"
 * )
 */
class GalleryNewsletter extends BaseItem
{
    /**
     * @var Newsletter
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Newsletter", inversedBy="galleries")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $newsletter;

    /**
     * @var Gallery
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Gallery")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    protected $gallery;

    /**
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param Gallery $gallery
     * @return $this
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getGallery()->__toString();
    }
}
