<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\EntityMap;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use AppBundle\Model\DescriptionTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\UpdatableSluggableByTitleTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Table(indexes={
 *     @ORM\Index(name="IDX_discr", columns={"discr"})
 * })
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 */
class AdministrativeUnit
{
    use IdentifiableTrait,
        EntitledTrait,
        UpdatableSluggableByTitleTrait,
        DescriptionTrait,
        ContentfulTrait,
        ImageTrait,
        TimestampableEntity;


    /**
     * @var AdministrativeArea
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AdministrativeArea", inversedBy="districts")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $parent;

    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="string", length=255)
     */
    protected $pageTitle;

    /**
     * @var boolean
     *
     * @Doctrine\ORM\Mapping\Column(name="publishable", type="boolean", options={"default" : 1})
     */
    protected $publishable = true;

    /**
     * @return AdministrativeArea
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param AdministrativeArea $administrativeArea
     */
    public function setParent(AdministrativeArea $administrativeArea)
    {
        $this->parent = $administrativeArea;
    }

    public function asArray()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'type' => EntityMap::getAlias($this)
        ];
    }

    public function getDisplayTitle()
    {
        return (string)$this;
    }

    /**
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * @param string $pageTitle
     * @return $this
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPublishable()
    {
        return $this->publishable;
    }
}
