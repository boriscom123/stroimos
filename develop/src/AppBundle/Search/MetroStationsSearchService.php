<?php
namespace AppBundle\Search;

use AppBundle\Model\ValueObject\FunctionalPurpose;
use Elastica\Filter as Filter;
use Elastica\Query as Query;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MetroStationsSearchService
{
    const SEARCH_RESULTS_LIMIT = 1000;

    /** @var ContainerInterface */
    private $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function find()
    {
        $query = new Query\Filtered();
        $query->setQuery(null);
        $query->setFilter((new Filter\Type())->setType(FunctionalPurpose::OBJ_FUNC__METRO));

        $resultSet = $this->container->get('fos_elastica.finder.app')->find($query, self::SEARCH_RESULTS_LIMIT);

        return $resultSet;
    }
}
