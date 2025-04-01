<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;


/**
 * Class Draft
 *
 * @ORM\Entity
 * @ORM\Table(
 *      name= "draft",
 *      uniqueConstraints={
 *          @oRM\UniqueConstraint(
 *              name="unique_draft_owner",
 *              columns={"owner_class_name", "owner_entity_id"}
 *          )
 *      }
 * )
 */
class Draft
{
    use EntitledTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_class_name", type="string", length=255, nullable=false)
     */
    protected $ownerClassName;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_entity_id", type="integer", nullable=false)
     */
    protected $ownerEntityId;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="edit_url", type="string", length=255, nullable=false)
     */
    private $editUrl;

    public function __construct(
        $object,
        $label,
        $editUrl
    ) {
        if (!($object instanceof EntitledInterface) || !($object instanceof PublishableInterface)) {
            throw new Exception('Can`t create draft for class ' . get_class($object));
        }
        $this->title = $object->getTitle();
        $this->ownerClassName = get_class($object);
        $this->ownerEntityId = $object->getId();
        $this->label = $label;
        $this->editUrl = $editUrl;
    }

    /**
     * @return string
     */
    public function getOwnerEntityId()
    {
        return $this->ownerEntityId;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEditUrl()
    {
        return $this->editUrl;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

}
