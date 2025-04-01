<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\ArticleSource;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadSourceData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 10; $i++) {
            $source = new ArticleSource();
            $source->setTitle($this->faker->company);
            $manager->persist($source);
            $this->setReference('source-'.$i, $source);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return FixturesOrder::L1;
    }
}
