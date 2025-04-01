<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory\Report;

use ApiBundle\InfrastructureLayer\QueryFactory\DoctrineQueryFactoryAbstract;
use AppBundle\Entity\SpotlightItem;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Gedmo\Loggable\Entity\LogEntry;

class SpotlightItemQueryFactory extends DoctrineQueryFactoryAbstract
{
    public function createQuery(array $filters = null)
    {
        $criteria = $this->converter->convert($filters);

        $qb = $this->queryBuilder;

        $tableAlias = 'logEntry';
        $qb->select($tableAlias)->from(LogEntry::class, $tableAlias);
        $qb->addCriteria($criteria);
        $qb->andWhere(
            $qb->expr()->andX(
                $qb->expr()->eq("{$tableAlias}.action", ':action'),
                $qb->expr()->eq("{$tableAlias}.objectClass", ':objectClass')
            )
        );
        $qb->setParameter(':action', 'create');
        $qb->setParameter(':objectClass', SpotlightItem::class);

        return new Paginator($qb);
    }
}
