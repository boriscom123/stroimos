<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Addressable\AddressableTrait;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

/**
 * @ORM\Entity
 * @ORM\Embeddable
 */
class Destruction
{
    use IdentifiableTrait;
    use AddressableTrait;

    /**
     * Серия дома
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @NotBlank(message="Поле не может быть пустым")
     */
    protected $series;

    /**
     * Год сноса
     *
     * @var integer
     * @ORM\Column(type="smallint", nullable=false, options={"unsigned":true})
     * @NotBlank(message="Поле не может быть пустым")
     * @Range(min="2010", minMessage="Год не может быть меньше 2010")
     */
    protected $destructionYear;

    /**
     * Календарный квартал сноса
     *
     * @var integer
     * @ORM\Column(type="smallint", nullable=false, options={"unsigned":true})
     * @NotBlank(message="Поле не может быть пустым")
     * @Range(min="1", max="4", minMessage="Квартал не может быть меньше 1", maxMessage="квартал не можетбыть больше 4")
     */
    protected $destructionQuarter;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $destructed;

    public function __construct()
    {
        $this->destructed = false;
        $this->destructionYear = date('Y');
        $this->destructionQuarter = 1;
    }

    /**
     * @return string
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * @param string $series
     */
    public function setSeries($series)
    {
        $this->series = $series;
    }

    /**
     * @return int
     */
    public function getDestructionYear()
    {
        return $this->destructionYear;
    }

    /**
     * @param int $destructionYear
     */
    public function setDestructionYear($destructionYear)
    {
        $this->destructionYear = $destructionYear;
    }

    /**
     * @return int
     */
    public function getDestructionQuarter()
    {
        return $this->destructionQuarter;
    }

    /**
     * @param int $destructionQuarter
     */
    public function setDestructionQuarter($destructionQuarter)
    {
        $this->destructionQuarter = $destructionQuarter;
    }

    /**
     * @return boolean
     */
    public function isDestructed()
    {
        return $this->destructed;
    }

    /**
     * @param boolean $destructed
     * @return $this
     */
    public function setDestructed($destructed)
    {
        $this->destructed = $destructed;
        return $this;
    }

    public function __toString()
    {
        return (string) $this->getAddress();
    }
}