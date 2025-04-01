<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class FetchPostViews extends BaseSpecification
{
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $qb->leftJoin($dqlAlias . '.views', '_views');
        $qb->addSelect('_views');
    }
}
