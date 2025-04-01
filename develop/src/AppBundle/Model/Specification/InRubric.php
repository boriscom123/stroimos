<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class InRubric extends BaseSpecification
{
    private $rubric;

    protected $dqlAlias;

    public function __construct($rubric, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);

        $this->rubric = $rubric;
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $qb->innerJoin($dqlAlias . '.rubrics', 'r', 'WITH', 'r.title = :title');
        $qb->setParameter('title', $this->rubric);
    }
}
