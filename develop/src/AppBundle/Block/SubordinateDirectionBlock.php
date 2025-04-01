<?php

namespace AppBundle\Block;

use AppBundle\Entity\Organization;
use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class SubordinateDirectionBlock extends BaseBlockService
{
    use CacheTrait;

    const SETTINGS_SUBORDINATE = 'subordinate';

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    public function getDefaultSettings()
    {
        return [
            self::SETTINGS_SUBORDINATE => null,
            'use_cache' => $this->useCache
        ];
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults($this->getDefaultSettings());
    }

    public function getCacheKeys(BlockInterface $block)
    {
        return $block->getSettings();
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $owner = $this->em->getRepository('AppBundle:Owner')->findOneBy([
            'name' => $blockContext->getSetting(self::SETTINGS_SUBORDINATE)
        ]);
        if(!$owner) {
            return $response ? $response : new Response();
        }
        /** @var Organization $organization */
        $organization = $owner->getOrganization();
        $head = $organization->getHead();
        $contactPersons = $this->em->getRepository('AppBundle:ContactPerson')->createQueryBuilder('c')
            ->andWhere('c.id != :head')
            ->andWhere('c.organization = :organization')
            ->andWhere('c.weight > 0')
            ->setParameter('head', $head)
            ->setParameter('organization', $organization)
            ->orderBy('c.weight', 'DESC')
            ->getQuery()->getResult();

        return $this
            ->renderResponse(
                $blockContext->getTemplate(),
                [
                    'head' => $head,
                    'contactPersons' => $contactPersons,
                    'blockContext' => $blockContext,
                    'block' => $this
                ],
                $response
            )
            ->setTtl(60);
    }
}
