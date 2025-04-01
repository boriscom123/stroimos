<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class GalleryPicsRepository extends EntityRepository
{
    /**
     * @param $galleryId int
     *
     * @return bool
     */
    public function hasGallery($galleryId)
    {
        return $this->createQueryBuilder('gp')
            ->select('gp.id')
            ->where('IDENTITY(gp.gallery) = :galleryId')
            ->setParameter('galleryId', $galleryId)
            ->getQuery()->getOneOrNullResult(Query::HYDRATE_SCALAR) !== null;
    }

    public function getPicks()
    {
        return $this->createQueryBuilder('gp')
            ->select('gp', 'g')
            ->innerJoin('gp.gallery', 'g')
            ->where('g.publishable = true')
            ->orderBy('gp.id', 'ASC')
            ->getQuery()->getResult();
    }
}
