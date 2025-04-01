<?php
namespace AppBundle\Model;

use Application\Sonata\MediaBundle\Entity\Media;

interface MediaImageInterface
{
    /**
     * @return Media
     */
    public function getImage();

    /**
     * @param Media $image
     * @return $this
     */
    public function setImage(Media $image = null);
}