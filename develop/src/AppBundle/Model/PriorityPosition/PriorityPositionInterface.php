<?php
namespace AppBundle\Model\PriorityPosition;

interface PriorityPositionInterface
{
    const MAX_PRIORITY_VALUE = 8;
    const DEFAULT_PRIORITY_POSITION = 32767;

    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getPriorityPosition();

    /**
     * @param int $priorityPosition
     * @return $this
     */
    public function setPriorityPosition($priorityPosition);
}
