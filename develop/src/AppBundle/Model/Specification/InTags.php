<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class InTags extends BaseSpecification
{
    private $tags;

    protected $dqlAlias;

    public function __construct($tags, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);

        $this->tags = $tags;
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $qb->innerJoin($dqlAlias . '.tags', 't', 'WITH', 't IN (:in_tags)');
        $qb->setParameter('in_tags', $this->tags);
    }
}
