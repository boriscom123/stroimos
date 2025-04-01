<?php

namespace AppBundle\Entity\NewsletterItem;

use AppBundle\Entity\Newsletter;
use AppBundle\Entity\Video;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="newsletter_videos"
 * )
 */
class VideoNewsletter extends BaseItem
{
    /**
     * @var Newsletter
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Newsletter", inversedBy="videos")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $newsletter;

    /**
     * @var Video
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Video", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    protected $video;

    /**
     * @return Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param Video $video
     * @return $this
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getVideo()->__toString();
    }
}
