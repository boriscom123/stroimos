<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class VideoPicsRepository extends EntityRepository
{
    /**
     * @param $videoId int
     *
     * @return bool
     */
    public function hasVideo($videoId)
    {
        return $this->createQueryBuilder('vp')
            ->select('vp.id')
            ->where('IDENTITY(vp.video) = :videoId')
            ->setParameter('videoId', $videoId)
            ->getQuery()->getOneOrNullResult(Query::HYDRATE_SCALAR) !== null;
    }

    public function getPicks()
    {
        return $this->createQueryBuilder('vp')
            ->select('vp', 'v')
            ->innerJoin('vp.video', 'v')
            ->where('v.publishable = true')
            ->orderBy('vp.id', 'ASC')
            ->getQuery()->getResult();
    }
}
