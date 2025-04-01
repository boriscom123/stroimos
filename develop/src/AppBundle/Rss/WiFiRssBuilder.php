<?php
namespace AppBundle\Rss;

use AppBundle\Entity\Post;
use AppBundle\Routing\EntityUrlGenerator;
use AppBundle\Rss\WiFi\Channel;
use AppBundle\Rss\WiFi\Item;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class WiFiRssBuilder extends RssBuilder
{
    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @var string
     */
    protected $enclosureThumb = 'thumb960x470';

    /**
     * @var TwigEngine
     */
    private $twig;

    public function __construct(TranslatorInterface $translator, EntityUrlGenerator $entityUrlGenerator, UrlGeneratorInterface $urlGenerator, RequestStack $requestStack, MediaProviderInterface $mediaProviderInterface)
    {
        parent::__construct($translator, $entityUrlGenerator, $urlGenerator, $requestStack, $mediaProviderInterface);

        $this->channel
            ->logo(
                $this->requestStack->getMasterRequest()->getUriForPath('/images/logo.png')
            );
    }

    public function setTemplating(TwigEngine $twig)
    {
        $this->twig = $twig;
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
        /** @var Item $item */
        $item = $this->buildItem($post);

        $text = strip_tags($post->getContent(), '<p><blockquote><img><a><span>');
        $text = preg_replace('~<p\s(.*?)data-embedded-type="gallery"(.*?)>.+?(?:<\/p>)~s', '', $text);
        $baseUri = $this->requestStack->getMasterRequest()->getUriForPath('/');
        $text = str_replace('href="/', 'href="' . $baseUri, $text);
        $text = str_replace('src="/', 'src="' . $baseUri, $text);

        $relatedNews = $post->getRelatedNewsPosts();
        if($relatedNews->count() > 0) {
            $text .= $this->twig->render(':Rss:related.html.twig', ['news' => $relatedNews]);
        }

        $item->fullText($text);

        return $item;
    }
}