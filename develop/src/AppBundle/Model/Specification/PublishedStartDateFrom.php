<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\Spec;

class PublishedStartDateFrom extends PublishedSince
{
    protected function getSpec()
    {
        return $this->date ? Spec::gte('publishStartDate', $this->date) : null;
    }
}
