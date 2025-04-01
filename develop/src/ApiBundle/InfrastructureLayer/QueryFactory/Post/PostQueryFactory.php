<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory\Post;

use ApiBundle\InfrastructureLayer\QueryFactory\DoctrineQueryFactoryAbstract;
use AppBundle\Entity\Post;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PostQueryFactory extends DoctrineQueryFactoryAbstract
{
    public function createQuery(array $filters = null)
    {
        $criteria = $this->converter->convert($filters);

        $enabledFilters = $this->entityManager->getFilters()->getEnabledFilters();

        foreach ($enabledFilters as $filterName => $filter) {
            $this->entityManager->getFilters()->disable($filterName);
        }

        $qb = $this->queryBuilder;

        $tableAlias = 'posts';
        $qb->select($tableAlias)->from(Post::class, $tableAlias);
        $qb->addCriteria($criteria);

        return new Paginator($qb);
    }
}
