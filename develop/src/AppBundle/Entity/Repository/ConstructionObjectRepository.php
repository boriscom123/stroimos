<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Model\ConstructionObjectsSearch;
use Elastica\Query as Query;
use FOS\ElasticaBundle\Repository;

class ConstructionObjectRepository extends Repository
{
    public function search(ConstructionObjectsSearch $search)
    {
//        $query = new Query\MatchAll();

        return $this->findPaginated('');

    }
}
