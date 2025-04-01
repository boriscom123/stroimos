<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class NotificationRepository extends EntityRepository
{
    /**
     * @param int $entityId
     * @param string $module
     *
     * @return int
     */
    public function getTotalCount($entityId, $module)
    {
        $qb = $this->createQueryBuilder('n');

        return $qb->select($qb->expr()->count('n.id'))
            ->where('n.entityId = :entityId')
            ->andWhere('n.module = :module')
            ->setParameter('entityId', $entityId)
            ->setParameter('module', $module)
            ->getQuery()->getSingleScalarResult();
    }
}
