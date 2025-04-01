<?php

namespace AppBundle\Event;

use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use AppBundle\Entity\EmbeddedContent\Faq\FaqBlock;
use AppBundle\Entity\Page;
use AppBundle\Entity\Post;
use AppBundle\Entity\Video;
use Application\Sonata\MediaBundle\Entity\Media;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class SeoListener
{
    const OG_SITE_NAME = 'stroi.mos.ru';
    const OG_LOCALE = 'ru_RU';
    const FAQ_ANCHOR_PREFIX = 'faq-card-';
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $metadataSource = $this->getMetadataSource($request);
        if (!$metadataSource) {
            return;
        }

        $faqId = $this->extractFaqIdFromRequest($request);
        $faqBlock = $faqId ? $this->findFaqBlockById($faqId) : null;

        if ($faqBlock !== null) {
            $this->updateMetaDataFromFaqBlock($faqBlock, $metadataSource, $request);
        } else {
            $this->updateMetaDataFromEntity($metadataSource, $request);
        }
    }

    /**
     * @param Request $request
     * @return MetadataInterface|null
     */
    protected function getMetadataSource(Request $request)
    {
        $page = $request->get('page');
        if ($page instanceof MetadataInterface) {
            return $page;
        }

        foreach ($request->attributes as $paramName => $param) {
            if (strpos($paramName, '_') === 0) {
                continue;
            }

            if ($param instanceof MetadataInterface) {
                return $param;
            }
        }

        $page = $this->findPageByRoute($request->get('_route'));
        if ($page instanceof MetadataInterface) {
            return $page;
        }

        return null;
    }

    /**
     * @param $route
     * @return Page|null
     */
    protected function findPageByRoute($route)
    {
        return $this->container->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Page')->findOneBy(
            ['route' => $route]
        );
    }

    protected function extractFaqIdFromRequest(Request $request)
    {
        $campaign = $request->get('utm_campaign');

        $isRequestWithUtmToFaq = $request->get('utm_medium')
            && $campaign
            && strpos($campaign, self::FAQ_ANCHOR_PREFIX) !== false;

        if (!$isRequestWithUtmToFaq) {
            return null;
        }

        list($faqId, $questionIndex) = explode(
            '_',
            str_replace(self::FAQ_ANCHOR_PREFIX, '', $campaign)
        );

        return $faqId;
    }

    /**
     * @param $route
     * @return FaqBlock|null
     */
    protected function findFaqBlockById($faqId)
    {
        return $this->container
            ->get('doctrine.orm.entity_manager')
            ->getRepository(FaqBlock::class)->find($faqId);
    }

    protected function updateMetaDataFromFaqBlock(FaqBlock $faqBlock, MetadataInterface $entity, Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');

        $title = $faqBlock->getTitle();
        $seoPage->addTitle($title);
        $seoPage->addMeta('name', 'description', $faqBlock->getText() ?: $title);
        $seoPage->addMeta('name', 'keywords', $title);

        $url = $this->generateEntityUrl(
                $entity,
                [
                    'utm_medium' => $request->get('utm_medium'),
                    'utm_campaign' => $request->get('utm_campaign'),
                ]
            ).'#'.$request->get('utm_campaign');

        $seoPage
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $faqBlock->getText() ?: $title)
            ->addMeta('property', 'og:type', 'article')
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'og:site_name', self::OG_SITE_NAME)
            ->addMeta('property', 'og:locale', self::OG_LOCALE);


        $image = $faqBlock->getImage();
        if (!empty($image)) {
            $this->updateMetaDataImage($image);
        }

    }

    protected function generateEntityUrl($entity, $params = [])
    {
        return $this->container->get('app.entity_url_generator')->generate($entity, $params, true);
    }

    protected function updateMetaDataImage($image)
    {
        $seoPage = $this->container->get('sonata.seo.page');

        $seoPage->addMeta('property', 'twitter:image', $this->getImageUrl($image, 'thumb960x470'));
        $seoPage->addMeta('property', 'og:image', $this->getImageUrl($image, 'thumb960x470'));
        $seoPage->addMeta('property', 'og:image:width', '960');
        $seoPage->addMeta('property', 'og:image:height', '470');
    }

    protected function getImageUrl(Media $image, $format = 'thumb960')
    {
        return $this->container->get('sonata.media.twig.extension')->path($image, $format);
    }

    protected function updateMetaDataFromEntity(MetadataInterface $entity, Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');

        $seoPage->addTitle($entity->getTitle());
        $seoPage->addMeta('name', 'description', $entity->getMetaDescription());
        $seoPage->addMeta('name', 'keywords', $entity->getMetaKeywords());

        $ogType = $entity instanceof Video ? 'video' : 'website';

        $seoPage
            ->addMeta('property', 'og:title', $entity->getTitle())
            ->addMeta('property', 'og:description', $entity->getMetaDescription())
            ->addMeta('property', 'og:type', $ogType)
            ->addMeta('property', 'og:url', $this->generateEntityUrl($entity))
            ->addMeta('property', 'og:site_name', self::OG_SITE_NAME)
            ->addMeta('property', 'og:locale', self::OG_LOCALE)

            ->addMeta('property', 'twitter:title', $entity->getTitle())
            ->addMeta('property', 'twitter:description', $entity->getMetaDescription())
            ->addMeta('property', 'twitter:url', $this->generateEntityUrl($entity))
        ;

        if ($entity instanceof Post) {
            $seoPage
                ->addMeta('property', 'og:type', 'article')
                ->addMeta(
                    'property',
                    'article:published_time',
                    $entity->getPublishStartDate()->format(\DateTime::ISO8601)
                )
                ->addMeta('property', 'article:author', $entity->getAuthorName())
                ->addMeta('property', 'article:section', $entity->getCategory()->getTitle())
            ;
            foreach ($entity->getTags() as $tag) {
                $seoPage->addMeta('property', 'article:tag', $tag);
            }
        }

        if ($entity instanceof TeasingInterface) {
            $seoPage->addMeta('property', 'og:description', $entity->getTeaser());
        }

        $image = method_exists($entity, 'getImage')
            ? $entity->getImage()
            : null;


        if (empty($image)) {
            $seoPage->addMeta(
                'property',
                'twitter:image',
                $request->getSchemeAndHttpHost() . '/images/share_stroimos-min.png'
            );
            $seoPage->addMeta(
                'property',
                'og:image',
                $request->getSchemeAndHttpHost() . '/images/share_stroimos-min.png'
            );
            $seoPage->addMeta('property', 'og:image:width', '1200');
            $seoPage->addMeta('property', 'og:image:height', '630');
        } else {
            $this->updateMetaDataImage($image);
        }
    }
}
