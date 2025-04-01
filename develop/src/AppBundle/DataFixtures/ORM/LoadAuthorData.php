<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Author;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadAuthorData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 15; $i++) {
            $author = new Author();
            $author->setTitle($this->faker->name);
            $manager->persist($author);
            $this->setReference('author-'.$i, $author);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return FixturesOrder::L1;
    }
}
