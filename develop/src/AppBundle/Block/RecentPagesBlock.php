<?php

namespace AppBundle\Block;

use AppBundle\RecentPage\RecentPageManager;
use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class RecentPagesBlock extends AbstractBlockService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var RecentPageManager
     */
    protected $recentPageManager;

    public function setRecentPageManager(RecentPageManager $recentPageManager)
    {
        $this->recentPageManager = $recentPageManager;
    }

    /**
     * @param EntityManager $em
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack($requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getDefaultSettings()
    {
        return array(
            'template' => '::widgets/recent_pages.html.twig',  
        );
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $recentPages = array();
        foreach ($this->recentPageManager->getItems() as $item) {
            if ($entity = $this->em->getRepository($item['class'])->find($item['id'])) {
                $entity->isRecent = $item['isRecent'];
                $recentPages[] = $entity;
            };

        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'items' => $recentPages
        ), $response);
    }
}
