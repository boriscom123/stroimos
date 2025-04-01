<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class DecisionDocument - 'Решения об утверждении проектной документации'
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 *
 */
class DecisionDocument extends Document
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     * @NotBlank(message="Номер документа не может быть пустым")
     */
    protected $number;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @NotNull(message="Необходимо установить статус документа")
     */
    protected $status;

    /**
     * Дата утверждения
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $ApproveDate;

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return boolean
     */
    public function isStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getApproveDate()
    {
        return $this->ApproveDate;
    }

    /**
     * @param \DateTime $ApproveDate
     */
    public function setApproveDate($ApproveDate)
    {
        $this->ApproveDate = $ApproveDate;
    }

    public function getCategory()
    {
        return 'Решения об утверждении проектной документации';
    }

    public function getTypeName()
    {
        return 'Решения об утверждении проектной документации';
    }
}
