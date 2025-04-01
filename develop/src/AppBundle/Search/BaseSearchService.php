<?php
namespace AppBundle\Search;

use AppBundle\Model\BaseSearch;
use Elastica\Filter as Filter;
use Elastica\Filter\AbstractFilter;
use Elastica\Query as Query;
use Pagerfanta\Pagerfanta;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseSearchService
{
    use PublishedFilterTrait;

    /** @var ContainerInterface */
    private $container;

    /**
     * @var AbstractFilter
     */
    private $customFilter;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function setCustomFilter(AbstractFilter $filter)
    {
        $this->customFilter = $filter;
    }

    /**
     * @param BaseSearch $search
     * @param string $searchType
     * @param int $limit
     *
     * @return Pagerfanta
     */
    public function getPager(BaseSearch $search, $searchType, $limit)
    {
        $queryString = $search->getQuery();

        $filteredQuery = new Query\Filtered();
        $filter = new Filter\BoolAnd();
        $filter->addFilter(new Filter\Type($searchType));
        $filter->addFilter($this->createPublishedFilter());
        if($this->customFilter instanceof AbstractFilter) {
            $filter->addFilter($this->customFilter);
        }
        $filteredQuery->setFilter($filter);

        if (!empty($search->getRubric())) {
            $rubricId = $this->container->get('doctrine')
                ->getRepository('AppBundle:Rubric')->getRubricIdByTitle($search->getRubric());
            if($rubricId) {
                $rubricFilter = new Filter\Bool();
                $rubricFilter->addMust((new Filter\Term(['rubrics.id' => $rubricId])));
                $filter->addFilter($rubricFilter);
            }
        }

        if (!empty($queryString)) {
            $multiMatchQuery = new Query\MultiMatch();
            $multiMatchQuery->setQuery($queryString);
            $multiMatchQuery->setType(Query\MultiMatch::TYPE_PHRASE);
            $multiMatchQuery->setParam('slop', 3);
            $multiMatchQuery->setFields(['title', 'teaser', 'lead', 'contents', 'address']);
            $filteredQuery->setQuery($multiMatchQuery);
        }

        $query = new Query();
        $query->setQuery($filteredQuery);
        //todo Cортировка результатов по дате публикации, отключён подсчёт score по дате wrapQueryWithDateDistanceScore, см. DateDistanceTrait
        $query->setSort(array(
                'publish_start_date' => array(
                    'order' => 'desc',
                    'missing' => '_first'
                ))
        );

        /** @var Pagerfanta $pager */
        $pager = $this->container->get('fos_elastica.finder.app')->findPaginated($query);
        $pager->setMaxPerPage($limit);
        $offset = $search->getOffset();
        $pager->setCurrentPage((int)($offset/$limit) + 1);

        return $pager;
    }
}
