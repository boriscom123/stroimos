<?php
namespace AppBundle\Controller;

use AppBundle\Search\PublishedFilterTrait;
use Elastica\Filter as Filter;
use Elastica\Filter\BoolFilter;
use Elastica\Query as Query;
use Elastica\Search;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    const LIMIT = 10;

    use PublishedFilterTrait;

    /**
     * @Route("/search", name="app_search")
     */
    public function searchAction(Request $request)
    {
        $searchTypes = $this->getSearchTypes();
        $queryString = $request->query->get('q');
        $types = (array)$request->query->get('t', []);
        $offset = $request->query->get('offset', 0);
        $data = [
            'query' => [
                'q' => $queryString,
                't' => $types,
//                'offset' => $offset + self::LIMIT
            ],
            'types' => $searchTypes,
            'offset' => $offset,
            'maxPerPage' => self::LIMIT,
            'nbResults' => 0
        ];

        if (!empty($queryString)) {
            $multiMatchQuery = new Query\MultiMatch();
            $multiMatchQuery->setQuery($queryString);
	        $multiMatchQuery->setType(Query\MultiMatch::TYPE_PHRASE);
	        $multiMatchQuery->setParam('slop', 3);
            $multiMatchQuery->setFields(['title', 'author', 'teaser', 'lead', 'contents', 'address']);
//            $multiMatchQuery->setParam('minimum_should_match', '30%');
//            $multiMatchQuery = $this->wrapQueryWithDateDistanceScore($multiMatchQuery, '1w');

            /*
            todo: disabled extra features
            $user = $this->getUser();
            if ($user instanceof User) {
                $activityProfile = $user->getActivityProfile();
            }

            if (isset($activityProfile) && $activityProfile instanceof UserActivityProfile) {
                $activityBoostQuery = new Query\Bool();
                $activityBoostQuery->addMust($multiMatchQuery);

                if ($tagsAggregation = $activityProfile->getTagsAggregation()) {
                    arsort($tagsAggregation);
                    $terms = array_slice(array_keys($tagsAggregation), 0, 7);
                    $activityBoostQuery->addShould(
                        new Query\Terms('tags.id', $terms)
                    );
                }

                if ($rubricsAggregation = $activityProfile->getRubricsAggregation()) {
                    arsort($tagsAggregation);
                    $terms = array_slice(array_keys($rubricsAggregation), 0, 7);
                    $activityBoostQuery->addShould(
                        new Query\Terms('rubrics.id', $terms)
                    );
                }

                if ($queries = $activityProfile->getQueryAggreagtion()) {
                    arsort($queries);
                    $terms = array_slice(array_keys($queries), 0, 7);
                    $activityBoostQuery->addShould(
                        new Query\SimpleQueryString(implode(' ', $terms))
                    );
                }

                $multiMatchQuery = $activityBoostQuery;
            }*/

            $query = new Query\Filtered();
            $query->setQuery($multiMatchQuery);

            $typeFilters = [];
            foreach ($types as $type) {
                if (!isset($searchTypes[$type])) {
                    continue;
                }
                $searchType = $searchTypes[$type];

                $typeFilter = new Filter\Type($searchType[0]);

                if (!empty($searchType[1])) {
                    $andWrapper = new Filter\BoolAnd();
                    $andWrapper->addFilter($typeFilter);

                    foreach ($searchType[1] as $key => $value) {
                        $termFilter = new Filter\Term();
                        $termFilter->setTerm($key, $value);
                        $andWrapper->addFilter($termFilter);
                    }

                    $typeFilter = $andWrapper;
                }

                $typeFilters[] = $typeFilter;
            }

            $filter = new Filter\BoolAnd();

            // исключение пресс-релизов из общих результатов поиска.
            if(!in_array('press_releases', $types, true)) {
                $filter->addFilter((new Filter\BoolFilter())->addMustNot((new Filter\Term())->setTerm('category.alias', 'press_releases')));
            }

            /**
             * Excluding subordinate_publication type from common search results
             */
            $excludeType = (new Filter\BoolNot(new Filter\Type('subordinate_publication')));
            $filter->addFilter($excludeType);
            $filter->addFilter($this->createPublishedFilter());
            if (!empty($typeFilters)) {
                $typeFilter = new Filter\BoolOr();
                $typeFilter->setFilters($typeFilters);
                $filter->addFilter($typeFilter);
            }
            $query->setFilter($filter);
            $query = new Query($query);
            $query->setHighlight([
                'fields' => [
                    'title' => ['fragment_size' => 255],
                    'teaser' => ['fragment_size' => 255],
                    'lead' => ['fragment_size' => 255],
                    'content' => ['index_options' => 'offsets'],
                    'addressText' => ['fragment_size' => 255],
                ],
                'pre_tags' => ["<em class=\"highlight\">"],
                'post_tags' => ["</em>"],
            ]);
            //todo Cортировка результатов по дате публикации, отключён подсчёт score по дате wrapQueryWithDateDistanceScore, см. DateDistanceTrait
            $query->setSort(array(
                'publish_start_date' => array(
                    'order' => 'desc',
                    'missing' => '_first'
                ))
            );

            $index = $this->get('fos_elastica.finder.app');

            // следующие 2 строки должны идти именно в такой последовательности, иначе $nbResults будет равно лимиту числа результатов на страницу
            $nbResults = $index->createPaginatorAdapter($query)->getTotalHits();
            $paginatedResult = $index->findHybrid($query, self::LIMIT, [Search::OPTION_FROM => $offset]);

            if ($nbResults > 0) {
                $this->get('app.search.suggester')->saveQuery($queryString);
            }

            $data['nbResults'] = $nbResults;
            $data['currentPage'] = 1 + $offset / self::LIMIT;
            $data['results'] = $paginatedResult;

            $nextOffset = $offset + self::LIMIT;
            $data['next_offset'] = $nextOffset <= $nbResults ? $nextOffset : null;

            $data['limit'] = self::LIMIT;
        }

        $template = $request->isXmlHttpRequest()
            ? ":Search:_results.html.twig"
            : ":Search:search.html.twig";

        return $this->render($template, $data);
    }

    /**
     * @Route("/search/suggest", name="app_search_query_suggest")
     */
    public function suggestAction(Request $request)
    {
        $suggestion = $this->get('app.search.suggester')->suggestRaw($request->query->get('q'));

        return new JsonResponse($suggestion);
    }

    protected function getSearchTypes()
    {
        return $this->get('app.publication_catalogue')->getSearchTypes();
    }
}
