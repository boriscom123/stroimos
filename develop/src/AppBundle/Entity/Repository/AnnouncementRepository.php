<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class AnnouncementRepository extends EntityRepository
{
    public function getHomepageAnnouncements()
    {
        return $this->createQueryBuilder('a')
	        ->innerJoin('a.post', 'p')
            ->where('p.publishable = true')
			->orderBy('a.publishStartDate', 'DESC')
            ->getQuery()
			->getResult();
    }
}
