<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class HasTag extends BaseSpecification
{
    private $tag;

    protected $dqlAlias;

    public function __construct($tag, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);

        $this->tag = $tag;
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $qb->innerJoin($dqlAlias . '.tags', 't', 'WITH', 't.title = :title');
        $qb->setParameter('title', $this->tag);
    }
}
