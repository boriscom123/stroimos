<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Person;
use Doctrine\ORM\EntityRepository;

class QuoteRepository extends EntityRepository
{
    /**
     * @param Person $person
     * @return bool
     */
    public function personHasQuotes($person)
    {
        return count($this->createQueryBuilder('q')
            ->select('q.id')
            ->andWhere('q.person = :person')
            ->andWhere('q.publishable = true')
            ->setParameter('person', $person)
            ->getQuery()->getArrayResult()) > 0;

    }
}
