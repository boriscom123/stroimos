<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach (Category::$categories as $key => $item) {
            $category = new Category();
            $category->setTitle($item);
            $category->setAlias($key);
            $manager->persist($category);
            $this->addReference($key, $category);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return FixturesOrder::L1;
    }
}
