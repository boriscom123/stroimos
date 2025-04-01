<?php
namespace AppBundle\Search;

use Elastica\Filter as Filter;

trait PublishedFilterTrait
{
    public function createPublishedFilter(\DateTime $publishedAfter = null, \DateTime $publishedBefore = null)
    {
        $publishRange = [];
        if (isset($publishedAfter)) {
            $publishRange['gte'] = $publishedAfter->format('Y-m-d');
        }

        if (isset($publishedBefore)) {
            $publishRange['lte'] = $publishedBefore->format('Y-m-d');
        }

        $publishedFilter = new Filter\BoolFilter();

        $publishedFilter->addMust(
            (new Filter\Term(['publishable' => true]))
        );

        if (!empty($publishRange)) {
            $publishedFilter->addMust(
                (new Filter\BoolOr())
                    ->addFilter(new Filter\BoolNot(new Filter\Exists('publish_start_date')))
                    ->addFilter(new Filter\Range('publish_start_date', $publishRange))
            );
        }

        $publishedFilter->addMust(
            (new Filter\BoolOr())
                ->addFilter(new Filter\BoolNot(new Filter\Exists('publish_end_date')))
                ->addFilter(new Filter\Range('publish_end_date', ['gte' => 'now']))
        );

        $publishedFilter->addMust(
            (new Filter\BoolOr())
                ->addFilter(new Filter\BoolNot(new Filter\Exists('publish_start_date')))
                ->addFilter(new Filter\Range('publish_start_date', ['lte' => 'now']))
        );

        return $publishedFilter;
    }
}