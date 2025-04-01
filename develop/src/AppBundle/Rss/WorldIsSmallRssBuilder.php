<?php

namespace AppBundle\Rss;

use AppBundle\Entity\Post;
use AppBundle\Routing\EntityUrlGenerator;
use AppBundle\Rss\WorldSmall\Item;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Symfony\Cmf\Component\Routing\ChainRouter;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;

class WorldIsSmallRssBuilder extends RssBuilder
{
    /**
     * @var Feed
     */
    protected $feed;

    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @var string
     */
    protected $enclosureThumb = 'thumb960x470';
    /**
     * @var ChainRouter
     */
    private $router;

    public function __construct(
        TranslatorInterface $translator,
        EntityUrlGenerator $entityUrlGenerator,
        ChainRouter $router,
        RequestStack $requestStack,
        MediaProviderInterface $mediaProviderInterface
    ) {

        parent::__construct($translator, $entityUrlGenerator, $router, $requestStack, $mediaProviderInterface);
        $this->router = $router;
    }

    public function addItem(Post $post)
    {
        $item = $this->prepareFullTextItem($post);

        return $item;
    }


    public function buildItem(Post $post) {
        $item = parent::buildItem($post);

        $rubrics = $post->getRubrics();
        if (empty($rubrics)) {
            return $item;
        }

        $categories = [];
        foreach ($rubrics as $rubric) {
            $categories[] = $rubric->getTitle();
        }

        if (!empty($categories)) {
            $item->category(\implode(',', $categories));
        }

        return $item;
    }

    /**
     * @param Post $post
     * @return Item
     */
    protected function prepareFullTextItem(Post $post)
    {
        /** @var Item $item */
        $item = $this->buildItem($post);
        $content = $post->getWordIsSmallContent();
        if (!$content) {
            $content = $post->getContent();
        }

        $host = $this->router->getContext()->getHost();
        $scheme = $this->router->getContext()->getScheme();

        $text = strip_tags($content, '<p><blockquote><a><span><li><ol><ul>');
        $text = preg_replace('/href=\"(?!https?:\/\/)([^\">]+)\">/smu', 'href="'.$scheme.'://'.$host.'$1">', $text);
        /** @see http://red.demo-room.ru/issues/199 */
        $text = preg_replace('/(<p\s+[^>]*data-embedded-type[^>]+>).*?<\/p>/sm', '', $text);
        $item->fullText($text);

        return $item;
    }

    protected function createFeed()
    {
        return new Feed();
    }

    protected function createChannel()
    {
        return new Channel();
    }

    protected function createItem()
    {
        return new Item();
    }
}
