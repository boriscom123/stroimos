<?php
namespace AppBundle\Model;

use Doctrine\ORM\Mapping as ORM;

trait CurrentlyTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    protected $currently;

    /**
     * @return string
     */
    public function getCurrently()
    {
        return $this->currently;
    }

    /**
     * @param string $currently
     * @return $this
     */
    public function setCurrently($currently)
    {
        $this->currently = $currently;
        return $this;
    }
}