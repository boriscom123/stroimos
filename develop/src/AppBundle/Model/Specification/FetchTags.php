<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class FetchTags extends BaseSpecification
{
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $qb->leftJoin($dqlAlias . '.tags', '_tag');
        $qb->addSelect('_tag');
    }
}
