<?php

namespace Amg\Bundle\TagBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    public function getTagsForEntity($entityOrClass)
    {
        $class = is_object($entityOrClass)
            ? get_class($entityOrClass)
            : $entityOrClass;

        return $this->_em
            ->createQuery("
                SELECT t
                FROM {$this->_entityName} t
                WHERE t.id IN (
                    SELECT DISTINCT dt.id
                    FROM $class d
                    JOIN d.tags dt
                )
            ")
            ->getResult();

    }
}
