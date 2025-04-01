<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory\Report;

use ApiBundle\InfrastructureLayer\QueryFactory\DoctrineQueryFactoryAbstract;
use AppBundle\Entity\Announcement;
use AppBundle\Entity\Block;
use AppBundle\Entity\Document;
use AppBundle\Entity\Page;
use AppBundle\Entity\Person;
use AppBundle\Entity\Post;
use AppBundle\Report\ReportItem;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PagePersonQueryFactory extends DoctrineQueryFactoryAbstract
{
    public function createQuery(array $filters = null)
    {
        $criteria = $this->converter->convert($filters);

        $qb = $this->queryBuilder;

        $tableAlias = 'ig';
        $qb->select($tableAlias)->from(Person::class, $tableAlias);
        $qb->addCriteria($criteria);
        $qb->andWhere(
            "{$tableAlias}.publishable = true"
        );

        return new Paginator($qb);
    }
}
