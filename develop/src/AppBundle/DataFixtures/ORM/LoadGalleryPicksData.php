<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\GalleryPicks;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGalleryPicksData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        foreach(range(1, 5) as $i) {
            $galleryPicks = new GalleryPicks();
            $galleryPicks->setGallery($this->getReference('gallery-id-' . $i));
            $manager->persist($galleryPicks);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return FixturesOrder::L5;
    }
}
