<?php

namespace AppBundle\Block;

use AppBundle\Model\Specification\InOrderOf;
use AppBundle\Search\PublishedFilterTrait;
use Doctrine\ORM\EntityManager;
use Elastica\Filter as Filter;
use Elastica\Query as Query;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class DocumentListBlock extends AbstractBlockService
{
    use TemplateMapperTrait;
    use PublishedFilterTrait;

    const LIST_LIMIT = 9;
    const LIST_END_TEST = 1;

    protected $docClassMapping = array(
        'all' => 'AppBundle\Entity\Document',
        'draft' => 'AppBundle\Entity\DraftDocument',
        'law' => 'AppBundle\Entity\LawDocument',
        'decision' => 'AppBundle\Entity\DecisionDocument',
    );

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @param EntityManager $em
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack($requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param TransformedFinder $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getTemplateMap()
    {
        return [
            '_ajax_list' => '::widgets/document/_ajax_list.html.twig',
            'subordinate_ajax_list' => 'Subordinate/widgets/document/_ajax_list.html.twig'
        ];
    }

    public function getDefaultSettings()
    {
        $request = $this->requestStack->getCurrentRequest();
        $settings = [
            'template' => ':widgets:document/'. $request->get('category', 'all') .'/_list.html.twig',
            'limit'    => self::LIST_LIMIT,
            'offset'   => 0,
            'order_by' => InOrderOf::PUBLISHING,
            'category' => $request->get('category', 'all'),
            'number' => $request->get('number'),
            'status'   => $request->get('status', ''),
            'archive'   => $request->get('archive', 0),
            'approve_date_start' => $request->get('approve_date_start'),
            'approve_date_end'   => $request->get('approve_date_end'),
            'agency'   => $request->get('agency'),
            'rubrics'  => $request->get('rubrics'),
            'date_of_adding_start'  => $request->get('date_of_adding_start'),
            'date_of_adding_end'  => $request->get('date_of_adding_end'),
            'owner' => null
        ];

        return $settings;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $request = $this->requestStack->getCurrentRequest();

        $owner = $blockContext->getSetting('owner');
        $query = $this->createQuery($request, $owner, $blockContext);

        $filter = new Filter\BoolAnd();

        $filter->addFilter($this->createPublishedFilter(null, new \DateTime()));

        $category = $blockContext->getSetting('category');

        if (in_array($category, array('law', 'decision'))) {
            if ($number = $blockContext->getSetting('number')) {
                $numberTerm = new Filter\Term(array('number' => $number));
                $filter->addFilter($numberTerm);
            }
            if ('' !== $blockContext->getSetting('status')) {
                $statusTerm = new Filter\Term(array('status' => (bool) $blockContext->getSetting('status')));
                $filter->addFilter($statusTerm);
            }
            $approveDateRange = [];
            if ($blockContext->getSetting('approve_date_start')) {
                $approveDateStart = new \DateTime($blockContext->getSetting('approve_date_start'));
                $approveDateRange['gte'] = $approveDateStart->format('Y-m-d');
            }
            if ($blockContext->getSetting('approve_date_end')) {
                $approveDateEnd = new \DateTime($blockContext->getSetting('approve_date_end'));
                $approveDateRange['lte'] = $approveDateEnd->format('Y-m-d');
            }

            $this->addDateRangeFilter(
                'approve_date',
                $filter,
                $blockContext->getSetting('approve_date_start'),
                $blockContext->getSetting('approve_date_end')
            );
        }

        if ($category == 'law') {
            if ($agencyId = $blockContext->getSetting('agency')) {
                $filter->addFilter(new Filter\Term(array('outgoing_agency.id' => $agencyId)));
            }
            if ($selectedRubrics = $blockContext->getSetting('rubrics')) {
                $filter->addFilter(new Filter\Terms('rubrics.id', array(array_keys($selectedRubrics))));
            }
        }
        if ($category == 'draft') {
            $this->addDateRangeFilter(
                'date_of_adding',
                $filter,
                $blockContext->getSetting('date_of_adding_start'),
                $blockContext->getSetting('date_of_adding_end')
            );
            if ('-1' !== $blockContext->getSetting('archive')) {
                $archiveTerm = new Filter\Term(array('archive' => (bool) $blockContext->getSetting('archive')));
                $filter->addFilter($archiveTerm);
            }
        }

        if ('all' === $category) {
            $typeFilter = new Filter\BoolOr();
            foreach (['decision', 'law', 'draft'] as $documentCategory) {
                $typeFilter->addFilter(new Filter\Type($documentCategory . '_document'));
            }
        } else {
            $typeFilter = new Filter\Type($category . '_document');
        }
        $filter->addFilter($typeFilter);

        $query->setPostFilter($filter);

        $limit = $blockContext->getSetting('limit');
        $offset = $blockContext->getSetting('offset');
        $documents = $this->container->get('fos_elastica.finder.app')->createPaginatorAdapter($query)
                ->getResults($offset, $limit + self::LIST_END_TEST)
                ->toArray();
        ;

        $nextOffset = null;
        if (count($documents) === $limit + self::LIST_END_TEST) {
            $documents = array_slice($documents, 0, -self::LIST_END_TEST);
            $nextOffset = $offset + count($documents);
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'documents' => $documents,
            'limit' => $limit,
            'next_offset' => $nextOffset,
            'context' => $blockContext,
            'block' => $this,
            'rubrics' => $this->em->getRepository('AppBundle:DocumentRubric')->getRootNodes(),
            'agencies' => $this->em->getRepository('AppBundle:OutgoingAgency')->findAll(),
            'category' => $blockContext->getSetting('category'),
            'owner' => $owner
        ), $response);
    }

    /**
     * @param Request $request
     * @param string|null $owner
     * @return Query
     */
    private function createQuery(Request $request, $owner, BlockContextInterface $blockContext)
    {
        $query = new Query();
        $category = $blockContext->getSetting('category');

        if ($request->get('q', false)) {
            $fields = ['title', 'content'];
            $textForSearching = $request->get('q');
            if (in_array($category, ['law', 'decision'])) {
                $fields[] = 'number';
            }
            $matchQuery = new Query\MultiMatch();
            $matchQuery->setQuery($textForSearching);
            $matchQuery->setFields($fields);
            $query->setQuery($matchQuery);
            $query->addSort(array('_score' => array('order' => 'desc')));
        } else {
            //TODO add to $matchQuery
            $query->addSort(array('publish_start_date' => array('order' => 'desc')));
            if ($owner) {
                $ownerEntity = $this->em->getRepository('AppBundle:Owner')->findOneBy(['name' => $owner]);
                if($ownerEntity) {
                    $query->setQuery((new Query\BoolQuery())->addShould(
                        new Query\Term(['owners.search_name' => $ownerEntity->getSearchName()]))
                    );
                }
            }
        }
        return $query;
    }

    private function addDateRangeFilter($field, Filter\BoolAnd $filter, $startDate = null, $endDate = null)
    {
        $dateRange = [];
        if ($startDate) {
            $startDate = new \DateTime($startDate);
            $dateRange['gte'] = $startDate->format('Y-m-d');
        }
        if ($endDate) {
            $endDate = new \DateTime($endDate);
            $dateRange['lte'] = $endDate->format('Y-m-d');
        }
        if (!empty($dateRange)) {
            $filter->addFilter(new Filter\Range($field, $dateRange));
        }
        return $filter;
    }
}
