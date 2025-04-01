<?php

namespace AppBundle\Entity\EmbeddedContent\TextBlock;

use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UsagePlace
{
    use IdentifiableTrait;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $class;
    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $entityId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $title;

    private function __construct()
    {
    }

    public static function createFromEntity($entity)
    {
        $self = new self();
        $self->class = get_class($entity);
        $self->entityId = $entity->getId();
        $self->title = method_exists($entity, 'getTitle') ? $entity->getTitle() : (string)$entity;

        return $self;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return mixed
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
}
