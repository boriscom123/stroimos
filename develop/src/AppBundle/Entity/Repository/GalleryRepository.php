<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Model\PriorityPosition\PriorityPositionInterface;
use AppBundle\Model\PriorityPosition\PriorityPositionRepositoryInterface;
use AppBundle\Model\Specification\EntitySpecificationRepositoryTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\OrderBy;
use Happyr\DoctrineSpecification\Specification\Specification;

class GalleryRepository extends EntityRepository implements PriorityPositionRepositoryInterface
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

    public function matchWithPhotosTags(Specification $specification)
    {
        $qb = $this->createQueryBuilder($this->alias);
        $this->applySpecification($qb, $specification);
        $qb->getQuery();

        $qb->select("DISTINCT({$this->alias})");

        $qb2 = $this->createQueryBuilder('g')
            ->where($qb->expr()->in('g', $qb->getDQL()));

        $qb2->setParameters($qb->getParameters());
        $qb2->setFirstResult($qb->getFirstResult());
        $qb2->setMaxResults($qb->getMaxResults());

        /** @var OrderBy $orderBy */
        foreach ($qb->getDQLPart('orderBy') as $orderBy) {
            $orderByParts = explode(' ', str_replace('e.', 'g.', (string)$orderBy));
            $qb2->addOrderBy($orderByParts[0], $orderByParts[1]);
        }

        return $qb2->getQuery()->getResult();
    }
}
