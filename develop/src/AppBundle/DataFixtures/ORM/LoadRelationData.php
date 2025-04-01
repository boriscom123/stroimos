<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Model\Specification\InCategory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Spec;

class LoadRelationData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $relatedClasses = [
//            'AppBundle\Entity\Post' => 'getRelatedPosts',
            'AppBundle\Entity\Construction' => 'getRelatedConstructions',
            'AppBundle\Entity\Document' => 'getRelatedDocuments',
            'AppBundle\Entity\Gallery' => 'getRelatedGalleries',
            'AppBundle\Entity\Infographics' => 'getRelatedInfographics',
            'AppBundle\Entity\Video' => 'getRelatedVideos',
            'ExtraBundle\Entity\Initiative' => null,
        ];

        $forRelated = [];

        foreach ($relatedClasses as $relatedClass => $getter) {
            $forRelated[$relatedClass] = $manager->getRepository($relatedClass)->findAll();
        }

        $relatedClasses['AppBundle\Entity\News'] = 'getRelatedPosts';
        $relatedClasses['AppBundle\Entity\PressRelease'] = 'getRelatedPressReleases';

        $forRelated['AppBundle\Entity\News'] = $manager->getRepository('AppBundle\Entity\Post')->match(new AndX(
            new InCategory(Category::CATEGORY_NEWS)
        ));

        $forRelated['AppBundle\Entity\PressRelease'] = $manager->getRepository('AppBundle\Entity\Post')->match(new AndX(
            new InCategory(Category::CATEGORY_PRESS_RELEASE)
        ));

        foreach($forRelated as $relatedType => $relatedItems) {
            foreach ($relatedItems as $relatedItem) {
                foreach ($relatedClasses as $class => $getter) {
                    if (!is_array($forRelated[$class]) || empty($getter)) {
                        continue;
                    }

                    $count = rand(0, min(5, count($forRelated[$class])));
                    if (!$count) {
                        continue;
                    }

                    $collection = $relatedItem->$getter();
                    foreach((array)array_rand($forRelated[$class], $count) as $relatedToItemKey) {
                        $var = $forRelated[$class][$relatedToItemKey];
                        if (!$collection->contains($var)) {
                            $collection->add($var);
                        }
                    }
                }

                $manager->persist($relatedItem);
            }
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return FixturesOrder::L6;
    }
}
