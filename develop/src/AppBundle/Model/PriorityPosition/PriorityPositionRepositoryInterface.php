<?php
namespace AppBundle\Model\PriorityPosition;

interface PriorityPositionRepositoryInterface
{
    /**
     * @param PriorityPositionInterface $entity
     * @return PriorityPositionInterface[]
     */
    public function getPriorityPositions($entity = null);
}