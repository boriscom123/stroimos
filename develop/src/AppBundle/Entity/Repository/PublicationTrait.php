<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

trait PublicationTrait
{
    /**
     * @return EntityManager
     */
    abstract protected function getEntityManager();

    abstract protected function getEntityName();

    /**
     * @param $queryBuilder
     * @param $entityAlias
     * @deprecated In favor of Doctrine SQL filters (or remove them first)
     */
    public function addCommonConstrains($queryBuilder, $entityAlias)
    {
        $this->addPublishableCondition($queryBuilder, $entityAlias);
        $this->addPublishedCondition($queryBuilder, $entityAlias);
    }


    public function addPublishedCondition(QueryBuilder $queryBuilder, $entityAlias)
    {
        $now = new \DateTime();

        $queryBuilder->andWhere($queryBuilder->expr()->andX(
            "$entityAlias.publishStartDate IS NULL OR $entityAlias.publishStartDate <= :startDate",
            "$entityAlias.publishEndDate IS NULL OR $entityAlias.publishEndDate >= :endDate"
        ))
            ->setParameter('startDate', $now)
            ->setParameter('endDate', $now);
    }

    public function addPublishableCondition(QueryBuilder $queryBuilder, $entityAlias)
    {
        $queryBuilder->andWhere("$entityAlias.publishable IS NULL OR $entityAlias.publishable = true");
    }
}
