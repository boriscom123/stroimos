<?php

namespace AppBundle\Twig;

use AppBundle\Entity\SubordinateSocials;
use Doctrine\ORM\EntityManager;

class EntityManagerTwigExtension extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('subordinate_socials', [$this, 'getSubordinateSocials']),
        ];
    }

    /**
     * @param string $subordinateSlug
     * @return SubordinateSocials[]
     */
    public function getSubordinateSocials($subordinateSlug)
    {
        $owner = $this->entityManager->getRepository('AppBundle:Owner')->findOneBy([
            'name' => $subordinateSlug
        ]);

        return $this->entityManager->getRepository('AppBundle:SubordinateSocials')->findBy(
            ['owner' => $owner],
            ['weight' => 'DESC']
        );
    }

    public function getName()
    {
        return 'entity_manager_helper';
    }
}
