<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class FetchAdministrativeUnit extends BaseSpecification
{
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $qb->leftJoin($dqlAlias . '.administrativeUnit', '_au');
        $qb->addSelect('_au');
    }
}
