<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory\Report;

use ApiBundle\InfrastructureLayer\QueryFactory\DoctrineQueryFactoryAbstract;
use AppBundle\Entity\EmbeddedContent\Faq\FaqBlock;
use Doctrine\ORM\Tools\Pagination\Paginator;

class FaqQueryFactory extends DoctrineQueryFactoryAbstract
{
    public function createQuery(array $filters = null)
    {
        $criteria = $this->converter->convert($filters);

        $qb = $this->queryBuilder;

        $tableAlias = 'ig';
        $qb->select($tableAlias)->from(FaqBlock::class, $tableAlias);
        $qb->addCriteria($criteria);
        $qb->andWhere(
            "{$tableAlias}.publishable = true"
        );

        return new Paginator($qb);
    }
}
