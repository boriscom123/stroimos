<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;

class PublishingPeriod extends BaseSpecification
{
    /**
     * @var \DateTime
     */
    private $upperDate;
    /**
     * @var \DateTime
     */
    private $lowerDate;

    public function __construct(\DateTime $lowerDate = null,\DateTime $upperDate = null, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);
        $this->upperDate = $upperDate;
        $this->lowerDate = $lowerDate;
    }

    protected function getSpec()
    {
        $range = [];

        if ($this->upperDate) {
            $range[] = new PublishedUpTo($this->upperDate);
        }

        if ($this->lowerDate) {
            $range[] = new PublishedSince($this->lowerDate);
        }

        return call_user_func_array('Happyr\DoctrineSpecification\Spec::andX', $range);
    }
}
