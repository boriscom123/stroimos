<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

trait EntityManagerTrait
{
    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->manager;
    }

    /**
     * @param ObjectManager $manager
     * @return $this
     */
    protected function setManager(ObjectManager $manager)
    {
        $this->manager = $manager;
        return $this;
    }
}