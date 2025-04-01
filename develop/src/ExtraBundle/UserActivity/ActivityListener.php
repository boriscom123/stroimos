<?php
namespace ExtraBundle\UserActivity;

use Doctrine\ORM\EntityManager;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ActivityListener
{
    /**
     * @var EntityManager
     */
    private $manager;
    /**
     * @var ActivityCollector
     */
    private $collector;
    /**
     * @var SeoPageInterface
     */
    private $seoPage;

    public function __construct(EntityManager $manager, ActivityCollector $collector, SeoPageInterface $seoPage)
    {
        $this->manager = $manager;
        $this->collector = $collector;
        $this->seoPage = $seoPage;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        if (
            Request::METHOD_GET !== $request->getMethod() ||
            Response::HTTP_OK !== $response->getStatusCode()
        ) {
            return;
        }

        $route = $request->attributes->get('_route');
        if (
            'page' !== $route &&
            strpos($route, 'app_') !== 0
        ) {
            return;
        }

        $viewedEntity = $this->getViewedEntity($request, $response);

        $this->collector->collectPageView(
            $request,
            $response,
            $route,
            $request->attributes->get('_route_params'),
            $this->seoPage->getTitle(),
            $viewedEntity,
            $this->getSearchEngineQuery($request)
        );
    }

    protected function getViewedEntity(Request $request)
    {
        $attributes = $request->attributes;

        if ('page' === $attributes->get('_route')) {
            return $this->manager->getRepository('AppBundle:Page')->findOneBy([
                'slug' => $attributes->get('_route_params[slug]', null, true)
            ]);
        }

        if ($requestedId = $attributes->get('id')) {
            foreach ($attributes->all() as $attributeName => $attributeValue) {
                if (
                    is_object($attributeValue) &&
                    method_exists($attributeValue, 'getId') &&
                    $attributeValue->getId() == $requestedId
                ) {
                    return $attributeValue;
                }
            }
        }

        if ($requestedSlug = $attributes->get('slug')) {
            foreach ($attributes->all() as $attributeName => $attributeValue) {
                if (
                    is_object($attributeValue) &&
                    method_exists($attributeValue, 'getSlug') &&
                    $attributeValue->getSlug() == $requestedSlug
                ) {
                    return $attributeValue;
                }
            }
        }

        return null;
    }

    private function getSearchEngineQuery(Request $request)
    {
        $query = null;

        $referer = $request->headers->get('referer');

        if ($referer) {
            $urlInfo = parse_url($referer);
            if (
                $request->getHost() !== $urlInfo['host'] &&
                !empty($urlInfo['query'])
            ) {
                $queryArray = [];
                parse_str($urlInfo['query'], $queryArray);
                foreach (['q', 'text', 'query'] as $queryPath) {
                    if (!empty($queryArray[$queryPath])) {
                        $query = trim($queryArray[$queryPath]);
                        break;
                    }
                }
            }
        }

        return $query;
    }
}
