<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\GalleryPicsRepository")
 * @UniqueEntity(fields="gallery", message="Данная галерея уже используется в виджете")
 */
class GalleryPicks
{
    use IdentifiableTrait;

    /**
     * @var Gallery
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Gallery")
     */
    private $gallery;

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
     * @return GalleryPicks
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function __toString()
    {
        return $this->getGallery()->getTitle();
    }
}
