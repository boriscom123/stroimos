<?php

namespace AppBundle\Statistic;

use AppBundle\Entity\Post;
use AppBundle\Entity\PostViews;
use Doctrine\ORM\EntityManager;
use Nmure\CrawlerDetectBundle\CrawlerDetect\CrawlerDetect;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class PostViewListener
{
    /**
     * @var ChainRouterInterface
     */
    private $router;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var CrawlerDetect
     */
    private $crawlerDetect;

    /**
     * @param ChainRouterInterface $router
     * @param EntityManager $entityManager
     * @param CrawlerDetect $crawlerDetect
     */
    public function __construct(
        ChainRouterInterface $router,
        EntityManager $entityManager,
        CrawlerDetect $crawlerDetect
    )
    {
        $this->router = $router;
        $this->entityManager = $entityManager;
        $this->crawlerDetect = $crawlerDetect;
    }

    public function onKernelTerminate(PostResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->get('_route', false) != 'app_news_show') {
            return;
        }

        $referer = parse_url($request->headers->get('referer'));
        $excludeUrl = $this->router->generate('app_news_list_popular');

        //check for excluded url
        if (!empty($referer) && $referer['path'] == $excludeUrl) {
            return;
        }

        //check for crawlers and bots
        if ($this->crawlerDetect->isCrawler($request->headers->get('User-Agent'))) {
            return;
        }

        $post = $request->get('post', false);
        if (!$post instanceof Post) {
            return;
        }

        $postView = $this->entityManager->getRepository('AppBundle:PostViews')->find($post->getId());

        if (null == $postView) {
            $postView = new PostViews();
            $postView->setPost($post);
            $this->entityManager->persist($postView);
            $this->entityManager->flush($postView);
        } else {
            $this->entityManager->getConnection()->executeQuery(
                'UPDATE post_views SET count=count+1 WHERE post_id = :postId',
                ['postId' => $post->getId()]
            );
        }
    }
}