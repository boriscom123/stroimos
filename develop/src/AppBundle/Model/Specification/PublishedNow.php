<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class PublishedNow extends BaseSpecification
{
    protected function getSpec()
    {
        $now = new \DateTime();

        return Spec::andX(
             new Published()
            ,new PublishedSince($now)
            ,new PublishedUpTo($now)
        );
    }
}
