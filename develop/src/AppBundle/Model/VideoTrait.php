<?php
namespace AppBundle\Model;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;

trait VideoTrait
{
    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     */
    protected $video;

    /**
     * @return Media
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param Media $video
     * @return $this
     */
    public function setVideo(Media $video = null)
    {
        $this->video = $video;

        return $this;
    }
}
