<?php
namespace AppBundle\Model;

use Doctrine\ORM\Mapping as ORM;

trait PositionTrait
{
    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $position = 0;

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }
}
