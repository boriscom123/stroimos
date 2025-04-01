<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class TopNews extends BaseSpecification
{
    const DEFAULT_PUBLISHED_SINCE = "-14 day";
    const DEFAULT_LIMIT = 7;

    public function getSpec($publishedSince = self::DEFAULT_PUBLISHED_SINCE, $limit = self::DEFAULT_LIMIT)
    {
        return Spec::andX(
            Spec::leftJoin('views', 'v'),
            Spec::orX(
                Spec::gt('count', 0, 'v'),
                Spec::eq('inTop', true)
            ),
            new InOrderOf(InOrderOf::TOP_NEWS),
            Spec::limit(self::DEFAULT_LIMIT)
        );
    }
}
