<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class HasTagOrPhotoTag extends BaseSpecification
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

        $qb->leftJoin($dqlAlias . '.tags', 't1');
        $qb->join($dqlAlias . '.medias', 'm');
        $qb->leftJoin('m.tags', 't2');
        $qb->andWhere("t1.title = :tag_title OR t2.title = :tag_title ");
        $qb->setParameter('tag_title', $this->tag);
    }
}
