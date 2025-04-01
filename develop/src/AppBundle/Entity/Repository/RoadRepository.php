<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Road;
use AppBundle\Model\PriorityPosition\PriorityPositionInterface;
use AppBundle\Model\PriorityPosition\PriorityPositionRepositoryInterface;
use AppBundle\Model\RoadsSearch;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class RoadRepository extends EntityRepository implements PriorityPositionRepositoryInterface
{
    public function search(RoadsSearch $params)
    {
        $qb = $this->createQueryBuilder('r');

        if ($params->getType()) {
            $qb->where('r.roadType.value = :roadType')
                ->setParameter('roadType', (string)$params->getType());
        }

        if (!$params->isWithPriorityPosition()) {
            if ($params->isOrderByPriorityPosition()) {
                $qb->orderBy('r.priorityPosition', 'ASC');
            } else {
                $qb->orderBy('r.title');
            }
        } else {
            $qb->andWhere('r.priorityPosition < :default_priority_position')
                ->setParameter(':default_priority_position', PriorityPositionInterface::DEFAULT_PRIORITY_POSITION)
                ->orderBy('r.priorityPosition', 'ASC');
        }

        if ($params->getPublished() !== null) {
            $qb
                ->andWhere('r.publishable = :published')
                ->setParameter(':published', $params->getPublished());
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @param Road $entity
     * @return PriorityPositionInterface[]
     */
    public function getPriorityPositions($entity = null)
    {
        return $this->createQueryBuilder('e')
            ->where('e.roadType.value = :roadType')
            ->andWhere('e.priorityPosition < :default_priority_position')
            ->setParameter('roadType', (string)$entity->getRoadType())
            ->setParameter(':default_priority_position', PriorityPositionInterface::DEFAULT_PRIORITY_POSITION)
            ->orderBy('e.priorityPosition', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
