<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\VideoPicks;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadVideoPicksData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        foreach(range(1,4) as $i) {
            $videoPicks = new VideoPicks();
            $videoPicks->setVideo($this->getReference('video-pick-' . $i));
            $manager->persist($videoPicks);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return FixturesOrder::L5;
    }
}
