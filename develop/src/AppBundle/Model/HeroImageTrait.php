<?php
namespace AppBundle\Model;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Expression;

trait HeroImageTrait
{
    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     *
     * @Expression(
     *     "!this.getImage() or !this.getHeroImage() or this.getImage().getId() !== this.getHeroImage().getId()",
     *     message="Заголовочное изображение должно отличаться от основного"
     * )
     */
    protected $heroImage;

    /**
     * @return Media
     */
    public function getHeroImage()
    {
        return $this->heroImage;
    }

    /**
     * @param Media $heroImage
     * @return $this
     */
    public function setHeroImage(Media $heroImage = null)
    {
        $this->heroImage = $heroImage;
        return $this;
    }
}
