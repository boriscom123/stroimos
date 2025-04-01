<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\SpotlightItem;
use AppBundle\Entity\Post;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSpotlightItemData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < SpotlightItem::LIMIT; $i++) {
            $spotlightItem = new SpotlightItem();

            /** @var Post $post */
            $post = $this->getReference("spotlight-item-$i");

            $spotlightItem->setPost($post);

            $manager->persist($spotlightItem);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return FixturesOrder::L5;
    }
}
