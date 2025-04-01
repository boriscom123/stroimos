<?php

namespace AppBundle\Block;

use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnnouncementBlock extends BaseBlockService
{
    const DEFAULT_TEMPLATE = ':widgets:announcement.html.twig';

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
        return array(
            'template' => self::DEFAULT_TEMPLATE,
            'extra' => '',
            'use_cache' => true
        );
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
        $announcements = $this->em->getRepository('AppBundle:Announcement')->getHomepageAnnouncements();

        return $this
            ->renderResponse(
                $blockContext->getTemplate(),
                array(
                    'announcements' => $announcements,
                    'blockContext' => $blockContext,
                    'block' => $this
                ),
                $response
            )
            ->setTtl(600);
    }
}
