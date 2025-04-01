<?php
namespace AppBundle\Rss;

use AppBundle\Entity\Post;
use AppBundle\Routing\EntityUrlGenerator;
use AppBundle\Rss\Yandex\Channel;
use AppBundle\Rss\Yandex\Feed;
use AppBundle\Rss\Yandex\Item;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class YandexRssBuilder extends RssBuilder
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

    public function __construct(
        TranslatorInterface $translator,
        EntityUrlGenerator $entityUrlGenerator,
        UrlGeneratorInterface $urlGenerator,
        RequestStack $requestStack,
        MediaProviderInterface $mediaProviderInterface,
        $withLogo = true
    )
    {
        parent::__construct($translator, $entityUrlGenerator, $urlGenerator, $requestStack, $mediaProviderInterface);

        if($withLogo) {
            $this->channel
                ->logo(
                    $this->requestStack->getMasterRequest()->getUriForPath('/images/logo.png')
                )
                ->logoSquare(
                    $this->requestStack->getMasterRequest()->getUriForPath('/images/ya_square_logo.png')
                );
        }
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

    public function addItem(Post $post)
    {
        $item = $this->prepareFullTextItem($post);
        $item->genre('message');

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

        $text = strip_tags($post->getContent(), '<p><blockquote><a><span>');
        /** @see http://red.demo-room.ru/issues/199 */
        $text = preg_replace('/(<p\s+[^>]*data-embedded-type[^>]+>).*?<\/p>/sm', '', $text);
        $item->fullText($text);

        return $item;
    }
}