<?php
namespace AppBundle\Search;

use Elastica\Query as Query;

trait DateDistanceTrait
{
    public function wrapQueryWithDateDistanceScore(Query\AbstractQuery $query, $scale = '3d', $offset = null, \DateTIme $date = null)
    {
        $date =  $date ?: new \DateTime();

        $dateDecayQuery = new Query\FunctionScore();
        $dateDecayQuery->setQuery($query);
        $dateDecayQuery->addDecayFunction(
            Query\FunctionScore::DECAY_GAUSS,
            'publish_start_date',
            $date->format(DATE_ATOM),
            $scale,
            $offset,
            0.6
        );

        return $dateDecayQuery;
    }
}
