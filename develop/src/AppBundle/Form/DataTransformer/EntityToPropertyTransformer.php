<?php

namespace AppBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

class EntityToPropertyTransformer implements DataTransformerInterface
{
    protected $em;
    protected $class;
    protected $property;

    public function __construct(EntityManager $em, $class, $property = "title")
    {
        $this->em = $em;
        $this->class = $class;
        $this->property = $property;

    }

    public function transform($entity)
    {
        if (empty($entity)) {
            return null;
        }
        return (string) $entity;
    }


    public function reverseTransform($prop_value)
    {
        if (!$prop_value) {
            return null;
        }

        $class = $this->class;
        $class = $class::getTranslationEntityClass();

        $entity = $this->em->getRepository($class)->findOneBy(array($this->property => $prop_value));

        return $entity->getTranslatable();
    }
}
