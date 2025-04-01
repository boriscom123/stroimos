<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\EmailSubscription;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadEmailSubscriptionData extends AbstractFixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $user = new EmailSubscription();
        $user->setEmail('subscriber@example.com');
        $user->setHash('7d807c234393b86ebfcef9ea0d60b1a7');

        $manager->persist($user);
        $manager->flush();
    }
}
