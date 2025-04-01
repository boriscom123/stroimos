<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class Published extends BaseSpecification
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getSpec()
    {
        return Spec::eq('publishable', true);
    }
}
