<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use AppBundle\Model\FileTrait;
use AppBundle\Model\PositionTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GalleryMedia
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class DocumentHasMedia implements EntitledInterface
{
    use FileTrait, PositionTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Document", inversedBy="files")
     */
    protected $document;

    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Заполните заголовок прикреплённого файла")
     */
    protected $title;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getDocument()
    {
        return $this->document;
    }

    public function setDocument(Document $document = null)
    {
        $this->document = $document;
        return $this;
    }

    public function __toString()
    {
        return (string) $this->getTitle();
    }
}
