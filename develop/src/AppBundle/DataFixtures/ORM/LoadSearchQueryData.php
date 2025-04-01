<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\SearchQuery;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSearchQueryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $queries = [
            'москва',
            'московский зоопарк',
            'город',
        ];

        foreach ($queries as $i => $queryString) {
            $query = new SearchQuery();
            $query->setQuery($queryString);
            $query->setCount($i + 1);
            $manager->persist($query);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return FixturesOrder::L1;
    }
}
