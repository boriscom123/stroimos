<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ConstructionParameter implements IdentifiableInterface, EntitledInterface
{
    use IdentifiableTrait;

    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="string", length=255, unique=true)
     */
    protected $title;

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
