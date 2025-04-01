<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Model\PriorityPosition\PriorityPositionInterface;
use AppBundle\Model\PriorityPosition\PriorityPositionRepositoryInterface;
use AppBundle\Model\Specification\EntitySpecificationRepositoryTrait;
use Doctrine\ORM\EntityRepository;

class PersonRepository extends EntityRepository implements PriorityPositionRepositoryInterface
{
    use EntitySpecificationRepositoryTrait;

    public function getPriorityPositions($entity = null)
    {
        return $this->createQueryBuilder('e')
            ->where('e.priorityPosition < :default_priority_position')
            ->setParameter(':default_priority_position', PriorityPositionInterface::DEFAULT_PRIORITY_POSITION)
            ->orderBy('e.priorityPosition', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
