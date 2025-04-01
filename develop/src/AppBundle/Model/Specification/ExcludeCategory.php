<?php
namespace AppBundle\Model\Specification;

use AppBundle\Entity\Category;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class ExcludeCategory extends BaseSpecification
{
    /**
     * @var Category|string
     */
    private $category;

    public function __construct($category, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);
        $this->category = $category;
    }

    public function getSpec()
    {
        if ($this->category instanceof Category) {
            return Spec::eq('category', $this->category);
        }

        return Spec::andX(
            Spec::join('category', 'c'),
            Spec::neq('alias', $this->category, 'c')
        );
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        parent::modify($qb, $dqlAlias);
        if (!$this->category instanceof Category) {
            $qb->addSelect('c');
        }
    }
}
