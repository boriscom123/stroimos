<?php
namespace AppBundle\Model;

use Amg\Bundle\TagBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;

trait ShowLastNewsTrait
{
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $showLastNews;

    /**
     * @var Tag[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Amg\Bundle\TagBundle\Entity\Tag")
     */
    protected $lastNewsTags;

    /**
     * @return boolean
     */
    public function getShowLastNews()
    {
        return $this->showLastNews;
    }

    /**
     * @param boolean $showLastNews
     */
    public function setShowLastNews($showLastNews)
    {
        $this->showLastNews = $showLastNews;
    }

    /**
     * @return Tag[]|ArrayCollection
     */
    public function getLastNewsTags()
    {
        return $this->lastNewsTags ?: $this->lastNewsTags = new ArrayCollection();
    }

    /**
     * @param Tag[]|ArrayCollection $lastNewsTags
     */
    public function setLastNewsTags($lastNewsTags)
    {
        $this->lastNewsTags = $lastNewsTags;
    }
}
