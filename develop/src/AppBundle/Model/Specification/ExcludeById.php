<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class ExcludeById extends BaseSpecification
{
    private $exclude;

    /**
     * ExcludeById constructor.
     * @param null|array $exclude
     * @param null $dqlAlias
     */
    public function __construct($exclude, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);
        $this->exclude = $exclude;
    }

    protected function getSpec()
    {
        if(isset($this->exclude) && count($this->exclude) > 0) {
            return Spec::notIn('id', $this->exclude);
        }

        return;
    }
}
