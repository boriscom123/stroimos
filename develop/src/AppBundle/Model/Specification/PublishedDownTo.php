<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class PublishedDownTo extends BaseSpecification
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @param \DateTime $date
     */
    public function __construct(\DateTime $date)
    {
        parent::__construct();

        $this->date = $date;
    }

    protected function getSpec()
    {
        return Spec::gte('publishStartDate', $this->date);
    }
}
