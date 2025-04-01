<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class RubricRepository extends EntityRepository
{
    public function getRubricsForEntity($entityOrClass, $categoryAlias = null)
    {
        $class = is_object($entityOrClass)
            ? get_class($entityOrClass)
            : $entityOrClass;

        $category = $this->getEntityManager()->getRepository('AppBundle:Category')->findOneBy(array('alias' => $categoryAlias));

        $categoryCondition = '';
        if ($category) {
            $categoryCondition = "WHERE c.category = {$category->getId()}";
        }

        return $this->_em
            ->createQuery("
                SELECT r
                FROM {$this->_entityName} r
                WHERE r.id IN (
                    SELECT DISTINCT cr.id
                    FROM $class c
                    LEFT JOIN c.rubrics cr
                    $categoryCondition
                )
            ")
            ->useResultCache(true, 600)
            ->getResult();
    }

    public function getRubricIdByTitle($title)
    {
        return $this->createQueryBuilder('r')
            ->select('r.id')
            ->andWhere('r.title = :title')
            ->setParameter('title', $title)
            ->getQuery()->getOneOrNullResult(Query::HYDRATE_SINGLE_SCALAR);
    }
}