<?php
namespace AppBundle\Rss;

use AppBundle\Entity\Post;
use AppBundle\Routing\EntityUrlGenerator;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class RssBuilder
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
     * @var TranslatorInterface
     */
    protected $translator;
    /**
     * @var EntityUrlGenerator
     */
    protected $entityUrlGenerator;
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var MediaProviderInterface
     */
    protected $mediaProviderInterface;

    /**
     * @var string
     */
    protected $enclosureThumb = 'thumb960';

    public function __construct(TranslatorInterface $translator, EntityUrlGenerator $entityUrlGenerator, UrlGeneratorInterface $urlGenerator, RequestStack $requestStack, MediaProviderInterface $mediaProviderInterface)
    {
        $this->translator = $translator;
        $this->entityUrlGenerator = $entityUrlGenerator;
        $this->requestStack = $requestStack;
        $this->mediaProviderInterface = $mediaProviderInterface;

        $this->feed = $this->createFeed();
        $this->channel = $this->createChannel();
        $this->channel->appendTo($this->feed);

        $this->channel->title($this->translator->trans('short_title'))
            ->description($this->translator->trans('rss_description'))
            ->language('ru')
            ->url($urlGenerator->generate('page', ['slug' => ''], true))
            ->pubDate(time());
    }

    protected function createFeed()
    {
        return new Feed();
    }

    protected function createChannel()
    {
        return new Channel();
    }

    public function addItem(Post $post)
    {
        return $this->buildItem($post);
    }

    protected function buildItem(Post $post)
    {
        $item = $this->createItem();

        $item
            ->appendTo($this->channel)
            ->title($post->getTitle())
            ->description($post->getTeaser());

        // TODO: create interface to check
        if (method_exists($item, 'content')) {
            $item->content(preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/s', "", $post->getContent()));
        }

        $item
            ->pubDate($post->getPublishStartDate()->getTimestamp())
            ->url($this->entityUrlGenerator->generate($post, [], true));

        if ($post->getImage()) {
            $item->enclosure(
                $this->mediaProviderInterface->generatePublicUrl($post->getImage(), $this->enclosureThumb),
                0,
                $post->getImage()->getContentType()
            );
        }

        return $item;
    }

    protected function createItem()
    {
        return new RssItem();
    }

    public function render()
    {
        return $this->feed->render();
    }
}
