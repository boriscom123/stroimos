<?php
namespace AppBundle\Model\Specification;

use AppBundle\Entity\Owner;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class HasMultiOwner extends BaseSpecification
{
    /**
     * @var string
     */
    private $owner;

    protected $dqlAlias;

    public function __construct($owner = Owner::OWNER_STROI_MOS, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);

        $this->owner = $owner;
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $qb->addSelect('owners');
        $qb->innerJoin($dqlAlias . '.owners', 'owners', 'WITH', 'owners.name = :owner');
        $qb->setParameter('owner', $this->owner);
    }
}
