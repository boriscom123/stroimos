<?php
namespace AppBundle\Model;

interface XYInterface
{
    /**
     * @return int
     */
    public function getX();

    /**
     * @param int $x
     * @return $this
     */
    public function setX($x);

    /**
     * @return int
     */
    public function getY();

    /**
     * @param int $y
     * @return $this
     */
    public function setY($y);
}