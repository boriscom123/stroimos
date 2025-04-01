<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class ConstructionFinishedIn extends BaseSpecification
{
    /**
     * @var integer
     */
    private $year;

    /**
     * @param integer $year
     */
    public function __construct($year)
    {
        parent::__construct();

        $this->year = (int)$year;
    }

    protected function getSpec()
    {
        return Spec::andX(
            Spec::lte('endYear', $this->year)
        );
    }
}
