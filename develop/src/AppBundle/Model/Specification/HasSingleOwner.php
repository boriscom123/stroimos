<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class HasSingleOwner extends BaseSpecification
{
    /**
     * @var string
     */
    private $owner;

    protected $dqlAlias;

    public function __construct($owner, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);

        $this->owner = $owner;
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $qb->innerJoin($dqlAlias . '.owner', 'owner', 'WITH', 'owner.name = :owner');
        $qb->setParameter('owner', $this->owner);
    }
}
