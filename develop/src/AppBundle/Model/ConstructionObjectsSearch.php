<?php

namespace AppBundle\Model;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Request;

class ConstructionObjectsSearch
{
    const QUERY_PARAM__ADDRESS = 'search';
    const QUERY_PARAM__FUNCTIONAL_PURPOSES = 'func_type';
    const QUERY_PARAM__CONSTRUCTION_STATUS = 'status';
    const QUERY_PARAM__ADMINISTRATIVE_UNIT = 'adm_unit';
    const QUERY_PARAM__CONSTRUCTION_FINISH_YEAR = 'finish_year';
    const QUERY_PARAM__MAX_RESULTS = 'limit';
    const QUERY_PARAM__FIRST_RESULT = 'offset';
    const QUERY_PARAM__CONSTRUCTION_PARAMETER  = 'construction_parameter';
    const QUERY_PARAM__CONSTRUCTION_PARAMETER_VALUE  = 'construction_parameter_value';
    const QUERY_PARAM__ROAD_TYPE  = 'road_type';

    private $query;

    private $offset;

    private $limit;

    /** @var string[] */
    private $funcPurposes;

    private $constructionStatus;

    private $admUnit;

    private $constructionEndYear;

    private $constructionEndYearFrom;

    private $constructionParameter;

    private $constructionParameterValue;

    private $roadType;


    public static function createFromRequest(Request $request)
    {
        $search = new self();

        if ($request->get(self::QUERY_PARAM__ADDRESS)) {
            $search->setQuery($request->get(self::QUERY_PARAM__ADDRESS));
        }

        if ($request->get(self::QUERY_PARAM__FIRST_RESULT)) {
            $search->setOffset($request->get(self::QUERY_PARAM__FIRST_RESULT));
        }

        $funcs = array_filter((array)$request->get(self::QUERY_PARAM__FUNCTIONAL_PURPOSES));
        if (count($funcs) > 0) {
            $search->setFuncPurposes($funcs);
        }

        if ($request->get(self::QUERY_PARAM__CONSTRUCTION_STATUS)) {
            $search->setConstructionStatus($request->get(self::QUERY_PARAM__CONSTRUCTION_STATUS));
        }

        if ($request->get(self::QUERY_PARAM__ADMINISTRATIVE_UNIT)) {
            $search->setAdmUnit($request->get(self::QUERY_PARAM__ADMINISTRATIVE_UNIT));
        }

        if ($val = $request->get(self::QUERY_PARAM__CONSTRUCTION_FINISH_YEAR)) {
            $years = explode(',', $val);
            if (count($years) === 2) {
                list($finishYearFrom, $finishYearTo) = $years;
            }
            else {
               $finishYearFrom = null;
               $finishYearTo = $years[0];
            }
            $search->setConstructionEndYearFrom($finishYearFrom);
            $search->setConstructionEndYear($finishYearTo);
        }

        if ($request->get(self::QUERY_PARAM__CONSTRUCTION_PARAMETER)) {
            $search->setConstructionParameter($request->get(self::QUERY_PARAM__CONSTRUCTION_PARAMETER));
        }

        if ($request->get(self::QUERY_PARAM__CONSTRUCTION_PARAMETER_VALUE)) {
            $search->setConstructionParameterValue($request->get(self::QUERY_PARAM__CONSTRUCTION_PARAMETER_VALUE));
        }

        if ($request->get(self::QUERY_PARAM__ROAD_TYPE)) {
            $search->setRoadType($request->get(self::QUERY_PARAM__ROAD_TYPE));
        }

        return $search;
    }



    public static function createFromBlockContext(BlockContextInterface $blockContext)
    {
        $search = new self();

        try {
            $value = $blockContext->getSetting(self::QUERY_PARAM__ADDRESS);
            if ($value) {
                $search->setQuery($value);
            }
        }
        catch (\RuntimeException $exception) {}

        try {
            $value = $blockContext->getSetting(self::QUERY_PARAM__FIRST_RESULT);
            if ($value) {
                $search->setOffset($value);
            }
        }
        catch (\RuntimeException $exception) {}

        try {
            $funcs = array_filter((array)$blockContext->getSetting(self::QUERY_PARAM__FUNCTIONAL_PURPOSES));
            if (count($funcs) > 0) {
                $search->setFuncPurposes($funcs);
            }
        }
        catch (\RuntimeException $exception) {}

        try {
            $value = $blockContext->getSetting(self::QUERY_PARAM__CONSTRUCTION_STATUS);
            if ($value) {
                $search->setConstructionStatus($value);
            }
        }
        catch (\RuntimeException $exception) {}

        try {
            $value = $blockContext->getSetting(self::QUERY_PARAM__ADMINISTRATIVE_UNIT);
            if ($value) {
                $search->setAdmUnit($value);
            }
        }
        catch (\RuntimeException $exception) {}

        try {
            if ($val = $blockContext->getSetting(self::QUERY_PARAM__CONSTRUCTION_FINISH_YEAR)) {
                $years = explode(',', $val);
                if (count($years) === 2) {
                    list($finishYearFrom, $finishYearTo) = $years;
                }
                else {
                    $finishYearFrom = null;
                    $finishYearTo = $years[0];
                }
                $search->setConstructionEndYearFrom($finishYearFrom);
                $search->setConstructionEndYear($finishYearTo);
            }
        }
        catch (\RuntimeException $exception) {}

        return $search;
    }

    public function __construct()
    {
        $this->query = '';
        $this->offset = 0;
        $this->funcPurposes = [];
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     *
     * @return ConstructionObjectsSearch
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param mixed $offset
     *
     * @return ConstructionObjectsSearch
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     *
     * @return ConstructionObjectsSearch
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getFuncPurposes()
    {
        return $this->funcPurposes;
    }

    /**
     * @param mixed $funcPurposes
     *
     * @return ConstructionObjectsSearch
     */
    public function setFuncPurposes($funcPurposes)
    {
        $this->funcPurposes = $funcPurposes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConstructionStatus()
    {
        return $this->constructionStatus;
    }

    /**
     * @param mixed $constructionStatus
     *
     * @return ConstructionObjectsSearch
     */
    public function setConstructionStatus($constructionStatus)
    {
        $this->constructionStatus = $constructionStatus;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdmUnit()
    {
        return $this->admUnit;
    }

    /**
     * @param mixed $admUnit
     *
     * @return ConstructionObjectsSearch
     */
    public function setAdmUnit($admUnit)
    {
        $this->admUnit = (int)$admUnit;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConstructionEndYear()
    {
        return $this->constructionEndYear;
    }

    /**
     * @param mixed $constructionEndYear
     *
     * @return ConstructionObjectsSearch
     */
    public function setConstructionEndYear($constructionEndYear)
    {
        $this->constructionEndYear = $constructionEndYear;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConstructionParameter()
    {
        return $this->constructionParameter;
    }

    /**
     * @param mixed $constructionParameter
     */
    public function setConstructionParameter($constructionParameter)
    {
        $this->constructionParameter = $constructionParameter;
    }

    /**
     * @return mixed
     */
    public function getConstructionParameterValue()
    {
        return $this->constructionParameterValue;
    }

    /**
     * @param mixed $constructionParameterValue
     */
    public function setConstructionParameterValue($constructionParameterValue)
    {
        $this->constructionParameterValue = $constructionParameterValue;
    }
    /**
     * @param mixed $constructionParameterValue
     */
    public function setRoadType($constructionParameterValue)
    {
        $this->roadType = $constructionParameterValue;
    }

    /**
     * @return mixed
     */
    public function getRoadType()
    {
        return $this->roadType;
    }

    /**
     * @return mixed
     */
    public function getConstructionEndYearFrom()
    {
        return $this->constructionEndYearFrom;
    }

    /**
     * @param mixed $constructionEndYearFrom
     */
    public function setConstructionEndYearFrom($constructionEndYearFrom)
    {
        $this->constructionEndYearFrom = $constructionEndYearFrom;
    }
}
