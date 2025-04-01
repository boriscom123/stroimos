<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory\Report;

use ApiBundle\InfrastructureLayer\QueryFactory\DoctrineQueryFactoryAbstract;
use AppBundle\Entity\Post;
use AppBundle\Report\ReportItem;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Tools\Pagination\Paginator;

class InterviewQueryFactory extends DoctrineQueryFactoryAbstract
{
    public function createQuery(array $filters = null)
    {
        $criteria = $this->converter->convert($filters);

        $qb = $this->queryBuilder;

        $tableAlias = 'ig';
        $qb->select($tableAlias)->from(Post::class, $tableAlias);
        $qb->addCriteria($criteria);
        $qb->andWhere(
            "{$tableAlias}.category = 5 and {$tableAlias}.publishable = true"
        );

        return new Paginator($qb);
    }
}
