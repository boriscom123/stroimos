<?php
namespace Amg\DataCore\Model\Attachable;

use AppBundle\Entity\File;
use Doctrine\Common\Collections\ArrayCollection;

interface AttachableInterface
{
    /**
     * @param File[]|ArrayCollection $files
     */
    public function setFiles($files);

    /**
     * @return File[]|ArrayCollection
     */
    public function getFiles();
}
