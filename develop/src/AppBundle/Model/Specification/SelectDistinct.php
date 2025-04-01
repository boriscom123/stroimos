<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class SelectDistinct extends BaseSpecification
{
    public function __construct()
    {
        parent::__construct(null);
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $qb->distinct();
    }
}
