<?php


namespace ApiBundle\InfrastructureLayer\Converter\ConverterKendoGridStateToDoctrineCriteria;

use ApiBundle\InfrastructureLayer\Converter\ArrayToCriteriaConverterInterface;
use ApiBundle\InfrastructureLayer\Converter\ConverterKendoGridStateToDoctrineCriteria\Exception\ConverterException;

class SortConverter implements ArrayToCriteriaConverterInterface
{
    const FIELD_KEY = 'field';
    const DIRECTION_KEY = 'dir';


    public function convert(array $sort, array $filedAliases = null)
    {
        $res = [];
        if (isset($sort[self::FIELD_KEY]) || isset($sort[self::DIRECTION_KEY])) {
            $sort = [
                [
                    self::FIELD_KEY => $sort[self::FIELD_KEY],
                    self::DIRECTION_KEY => $sort[self::DIRECTION_KEY] ? $sort[self::DIRECTION_KEY] : 'ASC',
                ],
            ];
        }

        foreach ($sort as $ordering) {
            if (empty($ordering[self::FIELD_KEY])) {
                throw new ConverterException('Undefined order field');
            }
            $fieldName = $this->buildFieldName($ordering[self::FIELD_KEY], $filedAliases);

            $res[$fieldName] = $ordering[self::DIRECTION_KEY] ? $ordering[self::DIRECTION_KEY] : 'ASC';
        }

        return $res;
    }

    protected function buildFieldName($fieldName, array $fieldAliases = null)
    {
        if (null === $fieldAliases || empty($fieldAliases[$fieldName])) {
            return $fieldName;
        }

        return "{$fieldAliases[$fieldName]}.$fieldName";
    }
}
