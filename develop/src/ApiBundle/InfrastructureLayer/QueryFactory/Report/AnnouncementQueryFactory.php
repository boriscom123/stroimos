<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory\Report;

use ApiBundle\InfrastructureLayer\Converter\ArrayToCriteriaConverterInterface;
use ApiBundle\InfrastructureLayer\QueryFactory\DoctrineQueryFactoryAbstract;
use AppBundle\Entity\Announcement;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AnnouncementQueryFactory extends DoctrineQueryFactoryAbstract
{
    public function __construct(
        EntityManagerInterface $entityManager,
        ArrayToCriteriaConverterInterface $converter
    ) {
        $entityManager->getFilters()->disable('publishing_period');
        parent::__construct($entityManager, $converter);
    }

    public function createQuery(array $filters = null)
    {
        $criteria = $this->converter->convert($filters);

        $qb = $this->queryBuilder;

        $tableAlias = 'ig';
        $qb->select($tableAlias)->from(Announcement::class, $tableAlias);
        $qb->addCriteria($criteria);

        return new Paginator($qb);
    }
}
