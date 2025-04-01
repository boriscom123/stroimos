<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{
    public function isMenuExists($name)
    {
        $menuCount = $this->_em
            ->createQuery('SELECT count(m) FROM AppBundle:Menu m WHERE m.name = :name')
            ->setParameter('name', $name)
            ->getSingleScalarResult()
        ;

        return $menuCount > 0;
    }

    public function findMenuByName($name)
    {
        return $this->_em
            ->createQuery('SELECT m FROM AppBundle:Menu m WHERE m.name = :name')
            ->setParameter('name', $name)
            ->getOneOrNullResult()
        ;
    }
}