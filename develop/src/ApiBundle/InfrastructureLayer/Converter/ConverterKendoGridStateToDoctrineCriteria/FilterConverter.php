<?php


namespace ApiBundle\InfrastructureLayer\Converter\ConverterKendoGridStateToDoctrineCriteria;

use ApiBundle\InfrastructureLayer\Converter\ArrayToCriteriaConverterInterface;
use ApiBundle\InfrastructureLayer\Converter\ConverterKendoGridStateToDoctrineCriteria\Exception\ConverterException;
use Doctrine\Common\Collections\Criteria;

class FilterConverter implements ArrayToCriteriaConverterInterface
{
    const FILTERS_KEY = 'filters';
    const FIELD_KEY = 'field';
    const OPERATOR_KEY = 'operator';
    const VALUE_KEY = 'value';
    const LOGIC_KEY = 'logic';

    const OPERATION_MAP = [
        'eq' => 'eq',
        "neq" => 'neq',
        "isnull" => 'isNull',
        "isnotnull" => 'isNotNull',
        "lt" => 'lt',
        "lte" => 'lte',
        "gt" => 'gt',
        "gte" => 'gte',
        "startswith" => 'startWith',
        "endswith" => 'endswith',
        "contains" => 'contains',
        "in" => 'in',
//        "doesnotcontain" => "doesnotcontain",
//        "isempty" => "isempty",
//        "isnotempty" => "isnotempty",
    ];

    public function convert(array $filter, array $filedAliases = null)
    {
        if (!empty($filter[self::FILTERS_KEY])) {
            if (!isset($filter[self::LOGIC_KEY])) {
                throw new ConverterException("Logic operasion not found");
            }

            $logic = $filter[self::LOGIC_KEY];
            $logicMethod = "{$logic}X";

            $exprs = [];
            foreach ($filter[self::FILTERS_KEY] as $subFilter) {
                $expr = $this->convert($subFilter);
                if ($expr !== null) {
                    $exprs[] = $expr;
                }
            }
            if (empty($exprs)) {
                return null;
            }
            $expressionBuilder = Criteria::expr();

            return call_user_func_array([$expressionBuilder, $logicMethod], $exprs);
        }

        $argsToBuildExprAreEmpty = empty($filter[self::FIELD_KEY]) && empty($filter[self::OPERATOR_KEY]) && empty($filter[self::VALUE_KEY]);
        if ($argsToBuildExprAreEmpty) {
            return null;
        }

        return $this->buildExpressionForField(
            $this->buildFieldName($filter[self::FIELD_KEY], $filedAliases),
            $filter[self::OPERATOR_KEY],
            $filter[self::VALUE_KEY] ? $filter[self::VALUE_KEY] : null
        );
    }

    /**
     * @param $field
     * @param $operator
     * @param $value
     * @return mixed
     * @throws ConverterException
     */
    protected function buildExpressionForField($field, $operator, $value = null)
    {
        $operator = self::OPERATION_MAP[$operator];
        $exprBuilder = Criteria::expr();

        if (!method_exists($exprBuilder, $operator)) {
            throw new ConverterException("Operator {$operator} not found");
        }
        // TODO: catch exception from operator calling without value
        return $value ? $exprBuilder->$operator($field, $value) : $exprBuilder->$operator($field);
    }

    protected function buildFieldName($fieldName, array $fieldAliases = null)
    {
        if (null === $fieldAliases || empty($fieldAliases[$fieldName])) {
            return $fieldName;
        }

        return "{$fieldAliases[$fieldName]}.$fieldName";
    }
}
