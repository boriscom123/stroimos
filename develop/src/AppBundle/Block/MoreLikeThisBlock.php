<?php
namespace AppBundle\Block;

use Amg\Bundle\TagBundle\Entity\Tag;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Lead\LeadInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use AppBundle\Search\DateDistanceTrait;
use AppBundle\Search\PublishedFilterTrait;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Elastica\Filter as Filter;
use Elastica\Query as Query;

class MoreLikeThisBlock extends BaseBlockService
{
    const LIMIT = 8;
    const DEFAULT_TEMPLATE = '::/widgets/spotlight/_widget.html.twig';

    use PublishedFilterTrait,
        DateDistanceTrait;

    /**
     * @var PaginatedFinderInterface
     */
    protected $finder;

    public function setFinder(PaginatedFinderInterface $finder)
    {
        $this->finder = $finder;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'block_title' => 'Другие материалы по теме',
            'block_class' => 'other-materials container__full',
            'template' => self::DEFAULT_TEMPLATE,
            'limit'    => self::LIMIT,

            'search_string' => null,
            'subject' => null,
            'use_cache' => true,
        ]);
    }


    public function getCacheKeys(BlockInterface $block)
    {
        return $block->getSettings();
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $matchQuery = $this->buildMatchQuery(
            $blockContext->getSetting('search_string'),
            $blockContext->getSetting('subject')
        );

        $limit = $blockContext->getSetting('limit');

        $query = new Query\Filtered($matchQuery, $this->buildFilter());
        $items = $this->finder->createPaginatorAdapter($query)
            ->getResults(0, $limit + 1)
            ->toArray();

        $items = $this->clearItems($items, $blockContext->getSetting('subject'), $limit);

        return $this->renderResponse($blockContext->getTemplate(), [
                'items' => $items,
                'class' => $blockContext->getSetting('block_class'),
                'title' => $blockContext->getSetting('block_title'),
            ], $response)
            ->setTtl(600);
    }

    /**
     * @param $items
     * @param $subject
     * @param $limit
     * @return array
     */
    private function clearItems($items, $subject, $limit)
    {
        $items = array_filter($items, function ($item) use ($subject) {
            if(method_exists($item, 'getId') && method_exists($subject, 'getId')) {
                return !(get_class($item) == get_class($subject) && $item->getId() == $subject->getId());
            }

            return $item != $subject;
        });

        return array_slice($items, 0, $limit);
    }

    /**
     * @return Filter\BoolAnd
     */
    private function buildFilter()
    {
        $filter = new Filter\BoolAnd();
        $filter->addFilter($this->createPublishedFilter());
        $filter->addFilter((new Filter\BoolAnd())->addFilter(
            new Filter\BoolNot(
                (new Filter\BoolAnd())
                    ->addFilter(new Filter\Type('post'))
                    ->addFilter(new Filter\Term(['category.alias' => 'press_releases']))
            ))->addFilter((new Filter\BoolNot(new Filter\Type('subordinate_publication')))
        ));

        return $filter;
    }

    /**
     * @param $searchString
     * @param $subject
     * @return Query\AbstractQuery
     */
    private function buildMatchQuery($searchString, $subject)
    {
        $searchString = $this->composeSearchString($searchString, $subject);

        $matchQueries = [];

        if (!empty($searchString)) {
            $searchString = preg_replace('/\W+/u', ' ', implode(' ', $searchString));

            $searchStringMatchQuery = new Query\MultiMatch();
            $searchStringMatchQuery->setFields(['title', 'teaser', 'lead', 'content']);
            $searchStringMatchQuery->setQuery($searchString);

            $matchQueries[] = $searchStringMatchQuery;
        }


        if (method_exists($subject, 'getTags')) {
            $tagsQuery = new Query\BoolQuery();

            /** @var Tag $tag */
            foreach ($subject->getTags() as $tag) {
                $tagsQuery->addShould(new Query\Term(['tags.id' => $tag->getId()]));
            }

            $matchQueries[] = $tagsQuery;
        }

        if (count($matchQueries) == 0) {
            $matchQueries[] = new Query\MatchAll();
        }

        if (count($matchQueries) > 1) {
            $boolQuery = new Query\BoolQuery();
            foreach ($matchQueries as $matchQuery) {
                $boolQuery->addShould($matchQuery);
            }

            $matchQuery = $boolQuery;
        } else {
            $matchQuery = reset($matchQueries);
        }

        $date = $subject instanceof PublishingPeriodInterface
            ? $subject->getPublishStartDate()
            : new \DateTime();

        return $this->wrapQueryWithDateDistanceScore($matchQuery, '7d', '7d', $date);
    }

    /**
     * @param $searchString
     * @param $subject
     * @return array
     */
    private function composeSearchString($searchString, $subject)
    {
        $searchString = [$searchString];

        if ($subject instanceof EntitledInterface) {
            $searchString[] = $subject->getTitle();
        }

        if ($subject instanceof TeasingInterface) {
            $searchString[] = $subject->getTeaser();
        } elseif ($subject instanceof LeadInterface) {
            $searchString[] = $subject->getLead();
        }

        return array_filter($searchString);
    }
}
