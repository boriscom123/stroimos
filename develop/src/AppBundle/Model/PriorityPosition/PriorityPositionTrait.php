<?php

namespace AppBundle\Model\PriorityPosition;

use ApiBundle\InfrastructureLayer\Service\PostService;
use AppBundle\Entity\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

trait PriorityPositionTrait
{
    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $priorityPosition = PriorityPositionInterface::DEFAULT_PRIORITY_POSITION;

    /**
     * @return int
     */
    public function getPriorityPosition()
    {
        return $this->priorityPosition;
    }

    /**
     * @param int $priorityPosition
     * @return $this
     */
    public function setPriorityPosition($priorityPosition)
    {
        // keep priorityPosition in range 0..32767
        $this->priorityPosition = max(0, min($priorityPosition, PriorityPositionInterface::DEFAULT_PRIORITY_POSITION));

        return $this;
    }


    protected function toLowerTheNearestNeighborsFromBelow($currentPriority, $newPriority, PostRepository $postRepository) {
        if ($currentPriority === null) {
            $currentPriority = PriorityPositionInterface::DEFAULT_PRIORITY_POSITION;
        }

        $numberOfProcessed = 0;
        $lastPriority = $newPriority;
        $postsBelowNewPriority = $postRepository->findAllInPriorityRangeAndCategory(
            $newPriority,
            $currentPriority-1,
            $this->category->getId(),
            PriorityPositionInterface::MAX_PRIORITY_VALUE
        );

        foreach($postsBelowNewPriority as $post) {
            if ($post->priorityPosition !== $lastPriority) {
                break;
            }
            $post->priorityPosition++;
            if ($post->priorityPosition > PriorityPositionInterface::MAX_PRIORITY_VALUE) {
                $post->priorityPosition = PriorityPositionInterface::DEFAULT_PRIORITY_POSITION;
            }
            $lastPriority = $post->priorityPosition ;
            $numberOfProcessed++;
        }

        return $numberOfProcessed;
    }

    protected function toRaiseTheNearestNeighborsFromAbove($currentPriority, $newPriority, PostRepository $postRepository) {
        if ($currentPriority === null) {
            // TODO: throw error
            return 0;
        }

        $numberOfProcessed = 0  ;
        $lastPriority = $newPriority;
        $postsAboveNewPriority = $postRepository->findAllInPriorityRangeAndCategory(
            $currentPriority+1,
            $newPriority,
            $this->category->getId(),
            PriorityPositionInterface::MAX_PRIORITY_VALUE,
            'DESC'
        );
        foreach($postsAboveNewPriority as $post) {
            if ($post->priorityPosition !== $lastPriority ) {
                break;
            }
            $post->priorityPosition --;
            if ($post->priorityPosition  === 0) {
                // TODO: throw error
                break;
            }
            $lastPriority = $post->priorityPosition ;
            $numberOfProcessed++;
        }

        return $numberOfProcessed;
    }

    /**
     * @param int $newPriority
     * @param PostService $service
     */
    public function changePriority($newPriority, PostRepository $postRepository)
    {
        if ($newPriority === null || $newPriority === 0) {
            $this->priorityPosition = PriorityPositionInterface::DEFAULT_PRIORITY_POSITION;
            return $this->priorityPosition;
        }

        $currentPriority = $this->priorityPosition;
        $this->priorityPosition = $newPriority;

        $isMovedDown = $currentPriority && $newPriority > $currentPriority;
        if ($isMovedDown) {

            return $this->toRaiseTheNearestNeighborsFromAbove($currentPriority, $newPriority, $postRepository) + 1;
        }

        return $this->toLowerTheNearestNeighborsFromBelow($currentPriority, $newPriority, $postRepository) + 1;
    }
}
