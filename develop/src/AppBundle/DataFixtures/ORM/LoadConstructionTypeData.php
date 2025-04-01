<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ConstructionType;
use AppBundle\Model\ValueObject\FunctionalPurpose;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadConstructionTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    const REF_BASE__CONSTR_TYPE = 'construction-type-';

    public function load(ObjectManager $manager)
    {
        foreach (FunctionalPurpose::$labels as $alias => $title) {
            $type = new ConstructionType();
            $type->setAlias($alias);
            $type->setTitle($title);
            $manager->persist($type);
            $this->setReference(self::REF_BASE__CONSTR_TYPE . $alias, $type);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return FixturesOrder::L1;
    }
}
