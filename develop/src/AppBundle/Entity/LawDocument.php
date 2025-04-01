<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class LawDocument - 'Законы, указы, постановления, распоряжения'
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 *
 */
class LawDocument extends Document
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
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $type;

    public static $types = array(
        'Постановление', 'Распоряжение', 'Положение', 'Приказ', 'Протокол', 'Регламент',
        'Решение', 'Указ', 'Договор', 'Закон', 'Кодекс', 'Конституция',
    );

    /**
     * Исходящий орган
     *
     * @var LawDocument
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OutgoingAgency", inversedBy="lawDocuments")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $outgoingAgency;

    /**
     * @var DocumentRubric[]|ArrayCollection $rubrics
     *
     * @ORM\ManyToMany(targetEntity="DocumentRubric", cascade={"persist"})
     */
    protected $rubrics;

    /**
     * @return LawDocument
     */
    public function getOutgoingAgency()
    {
        return $this->outgoingAgency;
    }

    /**
     * @param OutgoingAgency $outgoingAgency
     * @return $this
     */
    public function setOutgoingAgency(OutgoingAgency $outgoingAgency)
    {
        $this->outgoingAgency = $outgoingAgency;
        return $this;
    }

    /**
     * @return DocumentRubric[]|ArrayCollection
     */
    public function getRubrics()
    {
        return $this->rubrics ?: $this->rubrics = new ArrayCollection();
    }

    /**
     * @param DocumentRubric[]|ArrayCollection $rubrics
     * @return $this
     */
    public function setRubrics($rubrics)
    {
        $this->rubrics = $rubrics;
        return $this;
    }

    public function addRubric(DocumentRubric $rubric)
    {
        if (!$this->getRubrics()->contains($rubric)) {
            $this->getRubrics()->add($rubric);
        }
    }

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
        return 'Законы, указы, постановления, распоряжения';
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    public function getTypeName()
    {
        return isset(self::$types[$this->getType()]) ? self::$types[$this->getType()] : '';
    }

    /**
     * @param int $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
