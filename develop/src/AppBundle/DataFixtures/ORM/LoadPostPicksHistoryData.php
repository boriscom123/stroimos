<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\PostPicksHistory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPostPicksHistoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $newsCategory = $this->getReference('news');
        for ($i = 0; $i<10; $i++) {
            $date = new \DateTime("-{$i} DAYS");
            $newsQueryBuilder = $manager->getRepository('AppBundle:Post')->createQueryBuilder('n');
            $newsQueryBuilder
                ->andWhere('n.category = :category')
                ->andWhere('n.publishable = :true')
                ->andWhere('n.publishStartDate <= :date')
                ->andWhere('n.publishEndDate IS NULL')
                ->setParameter('category', $newsCategory)
                ->setParameter('date', $date)
                ->setParameter('true', true)
                ->setMaxResults(4)
                ->orderBy('n.publishStartDate', 'DESC')
            ;
            $postPicksHistory = new PostPicksHistory();
            $postPicksHistory->setDate($date);
            $postPicksHistory->setPosts($newsQueryBuilder->getQuery()->getResult());

            $manager->persist($postPicksHistory);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return FixturesOrder::L5;
    }
}
