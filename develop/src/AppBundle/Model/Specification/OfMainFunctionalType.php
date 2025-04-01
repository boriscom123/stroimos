<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class OfMainFunctionalType extends BaseSpecification
{
    private $type;

    protected $dqlAlias;

    public function __construct($type, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);

        $this->type = $type;
    }

    protected function getSpec()
    {
        return Spec::andX(
            Spec::eq('customData.MainFunctional', $this->type)
        );
    }
}
