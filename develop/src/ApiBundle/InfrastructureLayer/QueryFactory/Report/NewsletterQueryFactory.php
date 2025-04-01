<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory\Report;

use ApiBundle\InfrastructureLayer\QueryFactory\DoctrineQueryFactoryAbstract;
use AppBundle\Entity\Announcement;
use AppBundle\Entity\Document;
use AppBundle\Entity\Newsletter;
use AppBundle\Entity\Post;
use AppBundle\Entity\Video;
use AppBundle\Report\ReportItem;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Tools\Pagination\Paginator;

class NewsletterQueryFactory extends DoctrineQueryFactoryAbstract
{
    public function createQuery(array $filters = null)
    {
        $criteria = $this->converter->convert($filters);

        $qb = $this->queryBuilder;

        $tableAlias = 'newsletter';
        $qb->select($tableAlias)->from(Newsletter::class, $tableAlias);
        $qb->addCriteria($criteria);

        return new Paginator($qb);
    }
}
