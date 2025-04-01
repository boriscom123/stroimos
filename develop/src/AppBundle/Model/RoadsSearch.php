<?php
namespace AppBundle\Model;

class RoadsSearch
{
    const QUERY_PARAM__TYPE = 'type';

    private $type;
    private $withPriorityPosition = false;
    private $orderByPriorityPosition = false;
    private $published  = null;

    public function __construct()
    {
        $this->type = null;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }



    /**
     * @param null $type
     *
     * @return RoadsSearch
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isWithPriorityPosition()
    {
        return $this->withPriorityPosition;
    }

    /**
     * @param boolean $withPriorityPosition
     * @return $this
     */
    public function setWithPriorityPosition($withPriorityPosition)
    {
        $this->withPriorityPosition = $withPriorityPosition;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isOrderByPriorityPosition()
    {
        return $this->orderByPriorityPosition;
    }

    /**
     * @param boolean $orderByPriorityPosition
     * @return $this
     */
    public function setOrderByPriorityPosition($orderByPriorityPosition)
    {
        $this->orderByPriorityPosition = $orderByPriorityPosition;
        return $this;
    }

    /**
     * @return null|boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param boolean|null $published
     * @return $this;
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }
}
