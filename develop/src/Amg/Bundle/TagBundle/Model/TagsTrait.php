<?php
namespace Amg\Bundle\TagBundle\Model;

use Amg\Bundle\TagBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;

trait TagsTrait
{
    /**
     * @var \Amg\Bundle\TagBundle\Entity\Tag[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Amg\Bundle\TagBundle\Entity\Tag")
     */
    private $tags;

    /**
     * @param ArrayCollection|Tag[] $tags
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return ArrayCollection|Tag[]
     */
    public function getTags()
    {
        return $this->tags ?: $this->tags = new ArrayCollection();
    }
}
