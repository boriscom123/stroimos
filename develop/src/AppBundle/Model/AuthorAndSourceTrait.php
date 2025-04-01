<?php
namespace AppBundle\Model;

use AppBundle\Entity\ArticleSource;
use AppBundle\Entity\Author;
use Doctrine\Common\Collections\ArrayCollection;

trait AuthorAndSourceTrait
{
    /**
     * @var Author
     *
     * @ORM\ManyToOne(targetEntity="Author", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $author;

    /**
     * @var ArticleSource[]|ArrayCollection $source
     *
     * @ORM\ManyToOne(targetEntity="ArticleSource", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $source;

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->author ? $this->author->getTitle() : '';
    }

    /**
     * @param string $author
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return ArticleSource[]|ArrayCollection
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param ArticleSource[]|ArrayCollection $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }
}
