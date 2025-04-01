<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory\Report;

use ApiBundle\InfrastructureLayer\QueryFactory\DoctrineQueryFactoryAbstract;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Tools\Pagination\Paginator;

class InfographicCollageQueryFactory extends DoctrineQueryFactoryAbstract
{
    public function createQuery(array $filters = null)
    {
        $criteria = $this->converter->convert($filters);

        $qb = $this->queryBuilder;
        $tableAlias = 'mm';
        $qb->select($tableAlias)->from(Media::class, $tableAlias);
        $qb->addCriteria($criteria);
        $qb->andWhere($tableAlias . ".name LIKE 'collage_%'");

        return new Paginator($qb) ;
    }
}
