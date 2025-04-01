<?php

namespace AppBundle\Block;

use AppBundle\Model\Specification\InOrderOf;
use AppBundle\Search\PublishedFilterTrait;
use Doctrine\ORM\EntityManager;
use Elastica\Filter as Filter;
use Elastica\Query as Query;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;

class SubordinatePublicationsListBlock extends AbstractBlockService
{
    use TemplateMapperTrait;
    use PublishedFilterTrait;

    const LIST_LIMIT = 9;
    const LIST_END_TEST = 1;

    protected $types = [
        'video',
        'subordinate_publication'
    ];

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var TransformedFinder
     */
    protected $finder;

    /**
     * @param EntityManager $em
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    /**
     * @param TransformedFinder $finder
     */
    public function setFinder($finder)
    {
        $this->finder = $finder;
    }

    public function getTemplateMap()
    {
        return [
            '_ajax_list' => 'Subordinate/widgets/publication/_ajax_list.html.twig'
        ];
    }

    public function getDefaultSettings()
    {
        return array(
            'template' => 'Subordinate/widgets/publication/_list.html.twig',
            'limit'    => self::LIST_LIMIT,
            'offset'   => 0,
            'order_by' => InOrderOf::PUBLISHING,
            'owner' => null
        );
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $query = new Query();
        $query->addSort(array('publish_start_date' => array('order' => 'desc')));

        if ($owner = $blockContext->getSetting('owner')) {
            $ownerEntity = $this->em->getRepository('AppBundle:Owner')->findOneBy(['name' => $owner]);
            if($ownerEntity) {
                $query->setQuery((new Query\BoolQuery())->addShould(
                    new Query\Term(['owners.search_name' => $ownerEntity->getSearchName()]))
                );
            }
        }

        $filter = new Filter\BoolAnd();
        $filter->addFilter($this->createPublishedFilter(null, new \DateTime()));
        $typeFilter = new Filter\BoolOr();
        foreach ($this->types as $type) {
            $typeFilter->addFilter(new Filter\Type($type));
        }
        $filter->addFilter($typeFilter);
        $query->setPostFilter($filter);

        $limit = $blockContext->getSetting('limit');
        $offset = $blockContext->getSetting('offset');
        $publications = $this->finder->createPaginatorAdapter($query)
                ->getResults($offset, $limit + self::LIST_END_TEST)
                ->toArray();
        ;

        $nextOffset = null;
        if (count($publications) === $limit + self::LIST_END_TEST) {
            $publications = array_slice($publications, 0, -self::LIST_END_TEST);
            $nextOffset = $offset + count($publications);
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'publications' => $publications,
            'limit' => $limit,
            'next_offset' => $nextOffset,
            'context' => $blockContext,
            'block' => $this,
            'owner' => $owner
        ), $response);
    }
}
