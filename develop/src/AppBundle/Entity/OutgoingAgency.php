<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class OutgoingAgency - Исходящий орган
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 */
class OutgoingAgency implements EntitledInterface
{
    use EntitledTrait,
        ORMBehaviors\Blameable\Blameable
    ;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LawDocument", mappedBy="outgoingAgency")
     */
    protected $lawDocuments;

    public function __construct()
    {
        $this->lawDocuments = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return LawDocument[] | ArrayCollection
     */
    public function getLawDocuments()
    {
        return $this->lawDocuments;
    }

    /**
     * @param LawDocument[] | ArrayCollection $lawDocuments
     * @return $this
     */
    public function setLawDocuments($lawDocuments)
    {
        $this->lawDocuments = $lawDocuments;
        return $this;
    }

    public function addLawDocument(LawDocument $document)
    {
        if (!$this->getLawDocuments()->contains($document)) {
            $this->getLawDocuments()->add($document);
        }
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}