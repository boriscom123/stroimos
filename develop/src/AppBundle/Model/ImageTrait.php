<?php
namespace AppBundle\Model;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;

trait ImageTrait
{
    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     * @ Not Null(message="Укажите изображение")
     */
    protected $image;

    /**
     * @return Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Media $image
     * @return $this
     */
    public function setImage(Media $image = null)
    {
        $this->image = $image;
        return $this;
    }
}
