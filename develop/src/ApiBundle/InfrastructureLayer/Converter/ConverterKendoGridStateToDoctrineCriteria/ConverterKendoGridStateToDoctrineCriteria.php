<?php

namespace ApiBundle\InfrastructureLayer\Converter\ConverterKendoGridStateToDoctrineCriteria;

use ApiBundle\InfrastructureLayer\Converter\ArrayToCriteriaConverterInterface;
use Doctrine\Common\Collections\Criteria;

class ConverterKendoGridStateToDoctrineCriteria implements ArrayToCriteriaConverterInterface
{
    const FILTER_KEY = 'filter';
    const SORT_KEY = 'sort';
    const OFFSET_KEY = 'skip';
    const LIMIT_KEY = 'take';
    /**
     * @var FilterConverter
     */
    private $filterConverter;
    /**
     * @var SortConverter
     */
    private $sortConverter;

    public function __construct(
        FilterConverter $filterConverter,
        SortConverter $sortConverter
    ) {
        $this->filterConverter = $filterConverter;
        $this->sortConverter = $sortConverter;
    }

    public function convert(array $criteriaAsArray, array $filedAliases = null)
    {
        $criteria = Criteria::create();

        if (isset($criteriaAsArray[self::FILTER_KEY])) {
            $expr = $this->filterConverter->convert($criteriaAsArray[self::FILTER_KEY], $filedAliases);
            if ($expr !== null) {
                $criteria->where($expr);
            }
        }

        if (!empty($criteriaAsArray[self::SORT_KEY])) {
            $orderings = $this->sortConverter->convert($criteriaAsArray[self::SORT_KEY], $filedAliases);
            $criteria->orderBy($orderings);
        }

        if (isset($criteriaAsArray[self::OFFSET_KEY])) {
            $criteria->setFirstResult($criteriaAsArray[self::OFFSET_KEY]);
        }

        if (isset($criteriaAsArray[self::LIMIT_KEY])) {
            $criteria->setMaxResults($criteriaAsArray[self::LIMIT_KEY]);
        }

        return $criteria;
    }
}
