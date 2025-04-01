<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class PublishedUpTo extends BaseSpecification
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @param \DateTime $date
     */
    public function __construct(\DateTime $date = null)
    {
        parent::__construct();

        $this->date = $date;
    }

    protected function getSpec()
    {
        return $this->date ? Spec::lte('publishStartDate', $this->date) : null;
    }
}
