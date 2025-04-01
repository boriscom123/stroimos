<?php
namespace AppBundle\Search;

use AppBundle\Entity\Construction;
use AppBundle\Model\ConstructionObjectsSearch;
use Elastica\Aggregation as Aggregation;
use Elastica\Filter as Filter;
use Elastica\Query as Query;
use Elastica\Script;
use FOS\ElasticaBundle\Elastica\Index;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Pagerfanta\Pagerfanta;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConstructionObjectSearchService
{
    /** @var ContainerInterface */
    private $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ConstructionObjectsSearch $search
     * @param array|null $order
     *
     * @return Pagerfanta
     */
    public function getPaginator(ConstructionObjectsSearch $search, $order = null)
    {
        /**
         * @see https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-filtered-query.html#_filter_strategy
         */
        $filteredQuery = (new Query\Filtered())
            ->setFilter($this->buildFilter($search))
            ->setQuery($this->buildMatchQuery($search))
            ->setParam('strategy', 'leap_frog_filter_first');

        if(is_array($order)) {
            $filteredQuery = (new Query())
                ->setQuery($filteredQuery)
                ->setSort($order);
        }

        /** @var Pagerfanta $paginator */
        $paginator = $this->container->get('fos_elastica.finder.app')->findPaginated($filteredQuery);
        $limit = $search->getLimit();
        if ($limit) {
            $paginator->setMaxPerPage($limit);
            $offset = $search->getOffset();
            $paginator->setCurrentPage((int)($offset/$limit) + 1);
        }

        return $paginator;
    }

    private function buildFilter(ConstructionObjectsSearch $search)
    {
        $filter = new Filter\BoolAnd();
        $filter->addFilter($this->getTypesFilter());

        if ($search->getRoadType()) {
            $filter->addFilter(
                (new Filter\BoolOr())->setFilters(
                    array_map(function ($value) {
                        return new Filter\Term(['roadType' => $value]);
                    }, $search->getRoadType())
                )
            );
        }

        $rangeParams = [];
        if ($yearEnd = $search->getConstructionEndYear()) {
            $rangeParams['lte'] = $yearEnd;
        }

        if ($yearFrom = $search->getConstructionEndYearFrom()) {
            $rangeParams['gte'] = $yearFrom;
        }

        if (!empty($rangeParams)) {
            $filter->addFilter(
                (new Filter\BoolOr())
                    ->addFilter(
                        new Filter\Range('constructionEndYear', $rangeParams)
                    )
                    ->addFilter(new Filter\BoolNot(new Filter\Exists('constructionEndYear')))
            );
        }

        if ($search->getConstructionStatus()) {
            $filter->addFilter(
                new Filter\Term(['constructionStatus' => $search->getConstructionStatus()])
            );
        }

        if ($search->getFuncPurposes()) {
            $filter->addFilter(
                (new Filter\BoolOr())->setFilters(
                    array_map(function ($funcPurpose) {
                        return new Filter\Term(['functionalPurpose' => $funcPurpose]);
                    }, $search->getFuncPurposes())
                )
            );
        }

        if ($search->getAdmUnit()) {
            $filter->addFilter(
                (new Filter\BoolOr())->setFilters([
                    new Filter\Term(['administrativeUnit.id' => $search->getAdmUnit()]),
                    new Filter\Term(['administrativeUnit.parent.id' => $search->getAdmUnit()]),
                ])
            );
        }

        $filter->addFilter((new Filter\Exists('title')));

        return $filter;
    }

    private function buildMatchQuery(ConstructionObjectsSearch $search)
    {
        if (!$search->getQuery() && !$search->getConstructionParameterValue()) {
            return new Query\MatchAll();
        }

        $shouldClause = [];
        if ($search->getQuery()) {
            $matchAddressQuery = new Query\Match();
            $matchAddressQuery->setFieldQuery('searchData', $search->getQuery());
            $matchAddressQuery->setFieldAnalyzer('searchData', 'address_search');
            $matchAddressQuery->setFieldType('searchData', 'boolean');
            $matchAddressQuery->setFieldOperator('searchData', 'and');
            $matchAddressQuery->setFieldMinimumShouldMatch('searchData', '1');

            $shouldClause[] = $matchAddressQuery;
        }

        $constructionParameterValue  = $search->getConstructionParameterValue();
        if ($constructionParameterValue) {
            $shouldClause[] = (new Query\Match())
                ->setParam("constructionParameterValues.value", $constructionParameterValue);
        }

        $constructionParameter  = $search->getConstructionParameter();
        if ($constructionParameter) {
            $shouldClause[] = (new Query\Match())
                ->setParam("constructionParameterValues.constructionParameter.title", $constructionParameter);
        }

        $matchBoolQuery = (new Query\BoolQuery())
            ->addShould($shouldClause)
            ->setParam('minimum_should_match', count($shouldClause));

        return $matchBoolQuery;
    }

    private function getTypesFilter()
    {
        $types = ['construction', 'metro', 'road'];

        $typeFilters = [];
        foreach ($types as $type) {
            $typeFilters[] = new Filter\Type($type);
        }

        return (new Filter\BoolOr())->setFilters($typeFilters);
    }

    public function getConstructionEndYearsRange()
    {
        $query = new Query(new Query\Filtered(null, new Filter\Range('constructionEndYear', ['gt' => 0])));
        $query->setSize(0);

        $aggrFilter = new Aggregation\Filter('year');
        $aggrFilter->addAggregation((new Aggregation\Max('max'))->setField('constructionEndYear'));
        $aggrFilter->addAggregation((new Aggregation\Min('min'))->setField('constructionEndYear'));
        $aggrFilter->setFilter($this->getTypesFilter());

        $query->addAggregation($aggrFilter);

        $result = $this->container->get('fos_elastica.index.app')->search($query)->getAggregations();
        $result = $result['year'];

        $currentYear = (int)date('Y');

        return [
            $result['min']['value'] ?: $currentYear,
            $result['max']['value'] ?: $currentYear + 5,
        ];
    }

    /**
     * @param ConstructionObjectsSearch $search
     * @param Construction $construction
     * @return array
     */
    public function getNearConstructionAggregation(ConstructionObjectsSearch $search, Construction $construction)
    {
        $query = $this->getNearConstructionFilteredQuery($search, $construction);
        $field = 'functionalPurpose';
        $termsAgg = new Aggregation\Terms($field);
        $termsAgg->setField($field);
        $termsAgg->setSize(20);
        $finalQuery = new Query();
        $finalQuery->setQuery($query);
        $finalQuery->setSize(0);
        $finalQuery->addAggregation($termsAgg);
        /** @var Index $index */
        $index = $this->container->get('fos_elastica.index.app');

        $result = $index->search($finalQuery)->getAggregations();

        if(!isset($result[$field]['buckets'])) {
            return [];
        }

        $buckets = $result[$field]['buckets'];

        return array_column($buckets, 'doc_count', 'key');
    }

    /**
     * @param ConstructionObjectsSearch $search
     * @param Construction $construction
     * @return array
     */
    public function getNearConstruction(
        ConstructionObjectsSearch $search,
        Construction $construction
    )
    {
        /** @var TransformedFinder $finder */
        $finder = $this->container->get('fos_elastica.finder.app');

        $query = $this->getNearConstructionFilteredQuery($search, $construction);
        $functionQuery = new Query\FunctionScore();
        $functionQuery->setQuery($query);
        $constrCoords = array_combine(array('lon', 'lat'), $construction->getGeoPointAsLonLatArray());

        $functionQuery->addScriptScoreFunction(
            new Script("doc['getGeoPointAsLonLatArray'].arcDistanceInKm({$constrCoords['lat']}, {$constrCoords['lon']})", null, 'groovy')
        );

        $finalQuery = new Query();
        $finalQuery->setQuery($functionQuery);
        $finalQuery->addSort(['_score' => ['order' => 'asc']]);

        $total = $finder->createPaginatorAdapter($query)->getTotalHits();
        $objects = $finder->findHybrid($finalQuery, $search->getLimit(), array('from' => $search->getOffset()));

        return array(
            'total' => $total,
            'objects' => $objects
        );
    }

    /**
     * @param ConstructionObjectsSearch $search
     * @param Construction $construction
     * @return Query\Filtered
     */
    private function getNearConstructionFilteredQuery(ConstructionObjectsSearch $search, Construction $construction)
    {
        $filter = new Filter\BoolAnd();
        $filter->addFilter($this->getTypesFilter());

        $constrCoords = array_combine(array('lon', 'lat'), $construction->getGeoPointAsLonLatArray());

        $geoFilter = new Filter\GeoDistance(
            'getGeoPointAsLonLatArray',
            $constrCoords,
            '5km'
        );

        $excludeItem =
            new Filter\BoolNot(
                new Filter\Ids('construction', array($construction->getId()))
            );

        $filter->addFilter($geoFilter);
        $filter->addFilter($excludeItem);

        if ($search->getFuncPurposes()) {
            $filter->addFilter(
                (new Filter\BoolOr())->setFilters(
                    array_map(function ($funcPurpose) {
                            return new Filter\Term(['functionalPurpose' => $funcPurpose]);
                        }, $search->getFuncPurposes())
                )
            );
        }

        $query = new Query\Filtered();
        $query->setFilter($filter);

        return $query;
    }
}
