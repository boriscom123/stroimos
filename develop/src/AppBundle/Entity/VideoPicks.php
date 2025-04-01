<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\VideoPicsRepository")
 * @UniqueEntity(fields="video", message="Данное видео уже используется в виджете")
 */
class VideoPicks
{
    use IdentifiableTrait;

    /**
     * @var Video
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Video")
     */
    private $video;

    /**
     * @return Gallery
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param Video $video
     *
     * @return VideoPicks
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    public function __toString()
    {
        return $this->getVideo() instanceof Video
            ? (string)$this->getVideo()
            : '';
    }
}
