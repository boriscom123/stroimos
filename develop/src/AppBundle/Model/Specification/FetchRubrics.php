<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class FetchRubrics extends BaseSpecification
{
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $qb->leftJoin($dqlAlias . '.rubrics', '_rb');
        $qb->addSelect('_rb');
    }
}
