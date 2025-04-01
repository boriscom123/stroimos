<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Redirect
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Redirect
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $oldUrl;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=511)
     */
    private $newUrl;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $entityReference;


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
     * Set oldUrl
     *
     * @param string $oldUrl
     *
     * @return Redirect
     */
    public function setOldUrl($oldUrl)
    {
        $this->oldUrl = $oldUrl;

        return $this;
    }

    /**
     * Get oldUrl
     *
     * @return string
     */
    public function getOldUrl()
    {
        return $this->oldUrl;
    }

    /**
     * Set newUrl
     *
     * @param string $newUrl
     *
     * @return Redirect
     */
    public function setNewUrl($newUrl)
    {
        $this->newUrl = $newUrl;

        return $this;
    }

    /**
     * Get newUrl
     *
     * @return string
     */
    public function getNewUrl()
    {
        return $this->newUrl;
    }

    /**
     * Set entityReference
     *
     * @param string $entityReference
     *
     * @return Redirect
     */
    public function setEntityReference($entityReference)
    {
        $this->entityReference = $entityReference;

        return $this;
    }

    /**
     * Get entityReference
     *
     * @return string
     */
    public function getEntityReference()
    {
        return $this->entityReference;
    }
}

