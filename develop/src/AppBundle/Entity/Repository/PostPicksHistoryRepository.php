<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Post;
use AppBundle\Entity\PostPicksHistory;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class PostPicksHistoryRepository extends EntityRepository
{

    /**
     * @param \DateTime $date
     * @return PostPicksHistory $postPicksHistory
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLast(\DateTime $date = null)
    {
        $queryBuilder = $this->createQueryBuilder('h');

        $queryBuilder
            ->orderBy('h.date', 'DESC')
            ->setMaxResults(1);

        if ($date) {
            $queryBuilder->andWhere('h.date <= :date')
                ->setParameter(':date', $date);
        }

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param \DateTime $date
     * @return Post[]
     */
    public function getPostsForLastPickUpTo(\DateTime $date = null)
    {
        $lastPick = $this->getLast($date);
        if (!$lastPick) {
            return [];
        }

        return $lastPick->getPosts();
    }
}
