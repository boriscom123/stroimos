<?php

namespace AppBundle\Entity;

use Amg\Bundle\TagBundle\Model\TagsTrait;
use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Metadata\MetadataTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodTrait;
use Amg\DataCore\Model\Searchable\SearchableTrait;
use AppBundle\Model\LifecycleTimestampableEntity;
use AppBundle\Model\MultiOwner;
use AppBundle\Model\MultiOwnerTrait;
use AppBundle\Model\RelatedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Document
 *
 * @ORM\Table(name="document")
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string", length=40)
 * @ORM\DiscriminatorMap({
 *      "document" = "Document",
 *      "decision" = "DecisionDocument",
 *      "law" = "LawDocument",
 *      "draft" = "DraftDocument",
 * })
 *
 * @ORM\AttributeOverrides({
 *     @ORM\AttributeOverride(
 *      name="title",
 *      column=@ORM\Column(length=255, type="string", length=1000)
 *     )
 * })
 * @ORM\HasLifecycleCallbacks()
 */
class Document implements
    EntitledInterface,
    PublishableInterface,
    PublishingPeriodInterface,
    MetadataInterface,
    MultiOwner
{
    use EntitledTrait,
        ContentfulTrait,
        MetadataTrait,
        PublishableTrait,
        PublishingPeriodTrait,
        SearchableTrait,
        LifecycleTimestampableEntity,
        RelatedTrait,
        TagsTrait,
        ORMBehaviors\Blameable\Blameable,
        MultiOwnerTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DocumentHasMedia", mappedBy="document", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $files;

    public function __construct()
    {
        $this->files = new ArrayCollection();
        $this->setPublishStartDate(new \DateTime());
    }

    /**
     * @return DocumentHasMedia[] | ArrayCollection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param ArrayCollection $files
     * @return $this
     */
    public function setFiles(ArrayCollection $files)
    {
        foreach($files as $file) {
            $this->addFile($file);
        }
        return $this;
    }

    /**
     * @param DocumentHasMedia $file
     * @return $this
     */
    public function addFile(DocumentHasMedia $file)
    {
        if (!$this->getFiles()->contains($file)) {
            $this->files->add($file);
            $file->setDocument($this);
        }
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
        $this->id = $id;
    }

    public function __toString()
    {
        return $this->getTitle() ?: '(документ без названия)';
    }

    public function getTypeName()
    {
        return '';
    }
}
