<?php

namespace AppBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

class PublicationRelationToPropertyTransformer implements DataTransformerInterface
{
    protected $em;
    protected $class;

    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->class = $class;

    }

    public function transform($entity)
    {
        if (empty($entity)) {
            return null;
        }

        return array('title' => (string) $entity, 'id' => $entity->getTarget()->getId());
    }

    public function reverseTransform($targetId)
    {
        if (!$targetId) {
            return null;
        }

        $entity = $this->em->getRepository('ApplicationAmgDataBundle:Publication')->find($targetId);

        if ($this->class && $entity) {
            $rtr = new $this->class;
            $rtr->setTarget($entity);
            return $rtr;
        }

        return null;
    }
}
