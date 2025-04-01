<?php
namespace AppBundle\Search;

use AppBundle\Entity\SearchQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Elastica\Index;
use Elastica\Query;
use Elastica\Suggest;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Suggester
{
    use ContainerAwareTrait;

    /**
     * @var EntityRepository
     */
    protected $queryRepository;
    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->queryRepository = $entityManager->getRepository('AppBundle:SearchQuery');
        mb_internal_encoding('UTF-8');
    }

    public function suggestRaw($query)
    {
        /*$query = [
            "query-suggest" => [
                "text" => $query,
                "completion" => [
                    "field" => "suggest"
                ]
            ]
        ];

        return $this->suggestIndex->request('_suggest', 'GET', $query)->getData();*/

        return $this->queryRepository
            ->createQueryBuilder('q')
            ->select('q.query')
            ->where('q.query LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('q.count', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getArrayResult();
    }

    public function saveQuery($query)
    {
        $query = $this->canonicalizeQuery($query);

        if ($this->queryExists($query)) {
            $this->updateQueryCount($query);
            return;
        }

        $this->createQuery($query);
    }

    protected function canonicalizeQuery($query)
    {
        $query = mb_strtolower($query);
        $query = preg_replace('/\W+/u', ' ', $query);
        $query = trim($query);
        return $query;
    }

    protected function queryExists($query)
    {
        return 0 < $this->queryRepository
            ->createQueryBuilder('q')
            ->select('COUNT(q)')
            ->where('q.query = :query')
            ->setParameter('query', $query)
            ->getQuery()
            ->getSingleScalarResult();
    }

    protected function updateQueryCount($query, $addCount = 1)
    {
        return $this->queryRepository
            ->createQueryBuilder('q')
            ->update('AppBundle:SearchQuery q')
            ->set('q.count', 'q.count + :add_count')
            ->where('q.query = :query')
            ->setParameter('query', $query)
            ->setParameter('add_count', $addCount)
            ->getQuery()
            ->execute();
    }

    protected function createQuery($query, $count = 1)
    {
        $searchQuery = new SearchQuery();
        $searchQuery->setQuery($query);
        $searchQuery->setCount($count);

        $this->entityManager->persist($searchQuery);
        $this->entityManager->flush();
    }
}