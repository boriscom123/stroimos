<?php
namespace AppBundle\Model;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

trait FileCollectionTrait
{
    /**
     * @var Media[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     */
    protected $files;

    /**
     * @return Media[]|ArrayCollection
     */
    public function getFiles()
    {
        return $this->files ?: $this->files = new ArrayCollection();
    }

    /**
     * @param Media[]|ArrayCollection $files
     * @return $this
     */
    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }
}