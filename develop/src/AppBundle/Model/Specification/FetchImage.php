<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class FetchImage extends BaseSpecification
{
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $qb->leftJoin($dqlAlias . '.image', '_i');
        $qb->addSelect('_i');
    }
}
