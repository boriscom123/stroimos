<?php
namespace AppBundle\Rss;

use AppBundle\Entity\Post;
use AppBundle\Routing\EntityUrlGenerator;
use AppBundle\Rss\Yandex\Item;
use AppBundle\Rss\Yandex\ZenChannel;
use AppBundle\Rss\Yandex\ZenFeed;
use AppBundle\Rss\Yandex\ZenItem;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class YandexZenRssBuilder extends YandexRssBuilder
{
    /**
     * @var TwigEngine
     */
    private $twig;

    /**
     * YandexZenRssBuilder constructor.
     * @param TranslatorInterface $translator
     * @param EntityUrlGenerator $entityUrlGenerator
     * @param UrlGeneratorInterface $urlGenerator
     * @param RequestStack $requestStack
     * @param MediaProviderInterface $mediaProviderInterface
     * @param bool $withLogo
     */
    public function __construct(
        TranslatorInterface $translator,
        EntityUrlGenerator $entityUrlGenerator,
        UrlGeneratorInterface $urlGenerator,
        RequestStack $requestStack,
        MediaProviderInterface $mediaProviderInterface,
        $withLogo = false
    ) {
        parent::__construct($translator, $entityUrlGenerator, $urlGenerator, $requestStack, $mediaProviderInterface,
            $withLogo);

        $this->channel->description($this->translator->trans('ya_zen_rss_description'));
    }

    public function setTemplating(TwigEngine $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return ZenFeed
     */
    protected function createFeed()
    {
        return new ZenFeed();
    }

    /**
     * @return ZenChannel
     */
    protected function createChannel()
    {
        return new ZenChannel();
    }

    /**
     * @return ZenItem
     */
    protected function createItem()
    {
        return new ZenItem();
    }


    public function addItem(Post $post)
    {
        /** @var ZenItem $item */
        $item = $this->prepareFullTextItem($post);
        $item->figure($this->twig->render(':Rss:yandex_zen_figure.xml.twig', ['post' => $post]));
        $item->category('evergreen');
        $item->author($post->getAuthor());

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

        $text = strip_tags($post->getContent(), '<a><p><img><b><i><video>');
        /** @see http://red.demo-room.ru/issues/199 */
        $text = preg_replace('/(<p\s+[^>]*data-embedded-type[^>]+>).*?<\/p>/sm', '', $text);
        $host = $this->requestStack->getMasterRequest()->getHost();
        $scheme = $this->requestStack->getMasterRequest()->getScheme();
        $text = preg_replace('/src=(\'|")\//s', 'src=$1' . $scheme . '://' . $host . '/', $text);
        $text = preg_replace('/href=(\'|")\//s', 'href=$1' . $scheme . '://' . $host . '/', $text);
        $text .= '<p>Подробнее читайте на нашем <a href="'.$this->entityUrlGenerator->generate($post, [], true).'">сайте</a></p>';
        $item->fullText($text);

        return $item;
    }
}
