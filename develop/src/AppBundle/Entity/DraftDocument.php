<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class DraftDocument - 'Проекты правовых нормативных актов'
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 *
 */
class DraftDocument extends Document
{
    /**
     * Дата размещения
     *
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $dateOfAdding;

    /**
     * Дата окончания срока проведения независимой антикоррупционной экспертизы
     *
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $expirationDate;

    /**
     * Дата поступления текста заключения независимой антикоррупционной экспертизы
     *
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $dateOfReceipt;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @NotNull(message="Необходимо установить статус документа")
     */
    protected $archive;

    /**
     * @var string
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    protected $address;

    /**
     * @var string
     * @ORM\Column(type="string", length=1025, nullable=true)
     */
    protected $externalUrl;

    /**
     * @return \DateTime
     */
    public function getDateOfAdding()
    {
        return $this->dateOfAdding;
    }

    /**
     * @param \DateTime $dateOfAdding
     * @return $this
     */
    public function setDateOfAdding($dateOfAdding)
    {
        $this->dateOfAdding = $dateOfAdding;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfReceipt()
    {
        return $this->dateOfReceipt;
    }

    /**
     * @param \DateTime $dateOfReceipt
     * @return $this
     */
    public function setDateOfReceipt($dateOfReceipt)
    {
        $this->dateOfReceipt = $dateOfReceipt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param \DateTime $expirationDate
     * @return $this
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    public function getCategory()
    {
        return 'Проекты правовых нормативных актов';
    }

    /**
     * @return boolean
     */
    public function isArchive()
    {
        return $this->archive;
    }

    /**
     * @param boolean $archive
     * @return $this
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getExternalUrl()
    {
        return $this->externalUrl;
    }

    /**
     * @param string $externalUrl
     */
    public function setExternalUrl($externalUrl)
    {
        $this->externalUrl = $externalUrl;
    }

    public function getTypeName()
    {
        return 'Проекты правовых нормативных актов';
    }
}
