<?php
namespace AppBundle\Model;

use Symfony\Component\HttpFoundation\Request;

class BaseSearch
{
    const QUERY_PARAM__QUERY = 'q';
    const QUERY_PARAM__FIRST_RESULT = 'offset';
    const QUERY_PARAM__RUBRIC = 'rubric';

    /**
     * @var string
     */
    private $query;

    /**
     * @var integer
     */
    private $offset;

    /**
     * @var string
     */
    private $rubric;

    public static function createFromRequest(Request $request)
    {
        $search = new self();

        if ($request->get(self::QUERY_PARAM__QUERY)) {
            $search->setQuery($request->get(self::QUERY_PARAM__QUERY));
        }

        if ($request->get(self::QUERY_PARAM__FIRST_RESULT)) {
            $search->setOffset($request->get(self::QUERY_PARAM__FIRST_RESULT));
        }

        if ($request->get(self::QUERY_PARAM__RUBRIC)) {
            $search->setRubric($request->get(self::QUERY_PARAM__RUBRIC));
        }

        return $search;
    }

    public function __construct()
    {
        $this->query = '';
        $this->offset = 0;
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
     * @return $this
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
     * @param int $offset
     *
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return string
     */
    public function getRubric()
    {
        return $this->rubric;
    }

    /**
     * @param string $rubric
     *
     * @return $this
     */
    public function setRubric($rubric)
    {
        $this->rubric = $rubric;

        return $this;
    }
}
