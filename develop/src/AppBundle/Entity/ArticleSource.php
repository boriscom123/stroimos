<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleSource
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ArticleSource
{
    use EntitledTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Rubric
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}

