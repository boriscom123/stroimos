<?php
namespace AppBundle\Model;

trait XYTrait
{
    /**
     * @var int
     *
     * @Doctrine\ORM\Mapping\Column(type="integer", nullable=true)
     */
    protected $x;

    /**
     * @var int
     *
     * @Doctrine\ORM\Mapping\Column(type="integer", nullable=true)
     */
    protected $y;

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param int $x
     * @return $this
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param int $y
     * @return $this
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }
}
