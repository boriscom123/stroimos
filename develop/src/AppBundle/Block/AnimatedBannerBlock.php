<?php

namespace AppBundle\Block;

use AppBundle\Entity\Block;
use AppBundle\Entity\Page;
use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AnimatedBannerBlock extends BaseBlockService
{
	const PARAMS__PAGE = 'page';
    const DEFAULT_TEMPLATE = ':widgets:animated_hot_news_banners.html.twig';

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
	        self::PARAMS__PAGE => null,
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
	    $page = $blockContext->getSetting(self::PARAMS__PAGE);
	    $banners = null;
	    if($page && $page instanceof Page) {
		    $banners = $page->getBlocks(null, Block::TYPE_HOT_NEWS_BLOCK);
	    }

	    if(!$banners || count($banners) == 0) {
		    $banners = $this->em->getRepository('AppBundle:Block')->getHomePageBanners();
	    }

        return $this
            ->renderResponse($blockContext->getTemplate(), array(
                'banners' => $banners,
                'blockContext' => $blockContext,
                'block' => $this
            ), $response)
            ->setTtl(600);
    }
}
