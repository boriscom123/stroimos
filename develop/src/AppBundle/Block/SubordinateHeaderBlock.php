<?php

namespace AppBundle\Block;

use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubordinateHeaderBlock extends BaseBlockService
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

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $owner = $this->em->getRepository('AppBundle:Owner')
            ->findOneBy(['name' => $blockContext->getSetting(self::SETTINGS_SUBORDINATE)]);

        return $this->renderResponse($blockContext->getTemplate(), [
            'blockContext' => $blockContext,
            'organization' => $owner->getOrganization()
        ], $response)->setTtl(60);
    }
}
