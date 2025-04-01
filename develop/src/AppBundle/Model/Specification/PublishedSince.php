<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class PublishedSince extends BaseSpecification
{
    /**
     * @var \DateTime
     */
    protected $date;

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
        return $this->date
            ? Spec::orX(
                 Spec::gte('publishEndDate', $this->date)
                ,Spec::isNull('publishEndDate')
            )
            : null;
    }
}
