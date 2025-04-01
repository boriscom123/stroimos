<?php

namespace AppBundle\Entity\EmbeddedContent;

use AppBundle\Entity\Page;
use AppBundle\Entity\Person;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\QuoteRepository")
 */
class Quote extends BaseEmbeddedContent
{
    /**
     * @var Page[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Page", inversedBy="quotes")
     * @ORM\JoinTable(joinColumns={@ORM\JoinColumn(onDelete="RESTRICT")})
     */
    protected $pages;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $text;

    /**
     * @var Person
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Person", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $person;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Person $person
     * @return $this
     */
    public function setPerson($person)
    {
        $this->person = $person;

        return $this;
    }
}
