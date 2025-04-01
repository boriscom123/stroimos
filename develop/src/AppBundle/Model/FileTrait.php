<?php
namespace AppBundle\Model;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;

trait FileTrait
{
    /**
     * @var Media
     *
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    protected $file;

    /**
     * @return Media
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param Media $file
     * @return $this
     */
    public function setFile(Media $file = null)
    {
        $this->file = $file;
        return $this;
    }
}
