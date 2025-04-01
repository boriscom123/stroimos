<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory\Report;

use ApiBundle\InfrastructureLayer\QueryFactory\DoctrineQueryFactoryAbstract;
use AppBundle\Entity\Infographics;
use Doctrine\ORM\Tools\Pagination\Paginator;

class InfographicQueryFactory extends DoctrineQueryFactoryAbstract
{
    public function createQuery(array $filters = null)
    {
        $criteria = $this->converter->convert($filters);

        $qb = $this->queryBuilder;

        $tableAlias = 'ig';
        $qb->select($tableAlias)->from(Infographics::class, $tableAlias);
        $qb->addCriteria($criteria);

        return new Paginator($qb);
    }
}
