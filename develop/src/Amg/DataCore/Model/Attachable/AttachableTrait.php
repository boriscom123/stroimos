<?php
namespace Amg\DataCore\Model\Attachable;

use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\File;

trait AttachableTrait
{
    /**
     * @var File[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="File", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $files;

    /**
     * {@inheritdoc}
     */
    public function getFiles()
    {
        return $this->files = $this->files ?: new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }
}
