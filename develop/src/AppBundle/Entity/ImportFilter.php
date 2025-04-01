<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="import_filters")
 */
class ImportFilter implements IdentifiableInterface, EntitledInterface
{
    use IdentifiableTrait;

    /**
     * @var boolean
     *
     * @Doctrine\ORM\Mapping\Column(type="boolean")
     */
    protected $daily;
    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="json")
     */
    protected $filter;
    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="string", length=255, unique=true)
     */
    protected $title;

    /**
     * @return bool
     */
    public function getDaily()
    {
        return $this->daily;
    }

    /**
     * @param $daily
     * @return $this
     */
    public function setDaily($daily)
    {
        $this->daily = $daily;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param $filter
     * @return $this
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}
