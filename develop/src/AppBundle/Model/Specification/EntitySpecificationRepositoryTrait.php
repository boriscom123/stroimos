<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\Query\Expr\Composite;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\EntitySpecificationRepositoryTrait as BaseEntitySpecificationRepositoryTrait;
use Happyr\DoctrineSpecification\Result\ResultModifier;
use Happyr\DoctrineSpecification\Specification\Specification;

trait EntitySpecificationRepositoryTrait
{
    use BaseEntitySpecificationRepositoryTrait;

    /**
     * Creates a new QueryBuilder instance that is prepopulated for this entity name.
     *
     * @param string $alias
     * @param string $indexBy The index for the from.
     *
     * @return QueryBuilder
     */
    abstract public function createQueryBuilder($alias, $indexBy = null);

    public function getQuery(Specification $specification, ResultModifier $modifier = null)
    {
        $alias = $this->alias;
        $qb = $this->createQueryBuilder($alias);

        $specification->modify($qb, $alias);
        /** @var Composite $filters */
        $filters = $specification->getFilter($qb, $alias);
        if (null !== $filters && 0 !== $filters->count()) {
            $qb->where($filters);
        }

        $query = $qb->getQuery();

        if ($modifier !== null) {
            $modifier->modify($query);

            return $query;
        }

        return $query;
    }
}
