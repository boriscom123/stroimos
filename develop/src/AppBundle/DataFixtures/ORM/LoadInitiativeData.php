<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ExtraBundle\Entity\Initiative;
use Faker\Factory;

class LoadInitiativeData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
    }

    public function load(ObjectManager $manager)
    {
        foreach (range(1, 37) as $i) {
            $newsRow = TextSource::getNewsRow();
            $infographics = new Initiative();
            $infographics->setPublishable($this->faker->boolean(70));
            $infographics->setTitle($newsRow['name']);
            $infographics->setTeaser($newsRow['description']);
            $infographics->setContent($newsRow['text']);

            $manager->persist($infographics);
        }

        $manager->flush();
        $manager->clear();
    }

    public function getOrder()
    {
        return FixturesOrder::L3;
    }
}
