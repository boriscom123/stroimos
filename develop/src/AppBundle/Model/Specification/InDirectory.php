<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class InDirectory extends BaseSpecification
{
    private $directory;

    protected $dqlAlias;

    public function __construct($rubric, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);

        $this->directory = $rubric;
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $qb->innerJoin($dqlAlias . '.organizationDirectory', 'd', 'WITH', 'd.title = :title');
        $qb->setParameter('title', $this->directory);
    }
}
