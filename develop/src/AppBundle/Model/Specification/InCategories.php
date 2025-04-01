<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class InCategories extends BaseSpecification
{
    /**
     * @var array
     */
    private $categories;

    /**
     * InCategories constructor.
     * @param array $categories
     * @param null $dqlAlias
     */
    public function __construct($categories, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);
        $this->categories = $categories;
    }

    public function getSpec()
    {
        return Spec::andX(
            Spec::join('category', 'c'),
            Spec::in('alias', $this->categories, 'c')
        );
    }
}
