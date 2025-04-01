<?php
namespace AppBundle\Model;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

trait ImageCollectionTrait
{
    /**
     * @var Media[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     */
    protected $images;

    /**
     * @return Media[]|ArrayCollection
     */
    public function getImages()
    {
        return $this->images ?: $this->images = new ArrayCollection();
    }

    /**
     * @param Media[]|ArrayCollection $images
     * @return $this
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }
}