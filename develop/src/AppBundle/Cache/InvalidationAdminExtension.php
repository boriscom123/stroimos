<?php
namespace AppBundle\Cache;

use AppBundle\Entity\Post;
use AppBundle\Routing\EntityUrlGenerator;
use FOS\HttpCacheBundle\CacheManager;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Symfony\Component\Routing\Exception\ExceptionInterface as RoutingExceptionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class InvalidationAdminExtension extends AdminExtension
{
    const ROUTE_SHOW_POSTFIX = '_show';
    const ROUTE_LIST_POSTFIX = '_list';
    /**
     * @var EntityUrlGenerator
     */
    private $urlGenerator;
    /**
     * @var CacheManager
     */
    private $cacheManager;
    /**
     * @var UrlGeneratorInterface
     */
    private $router;
    /**
     * @var array
     */
    private $routeDependencies;

    public function __construct(
        EntityUrlGenerator $urlGenerator,
        UrlGeneratorInterface $router,
        CacheManager $cacheManager,
        array $routeDependencies = []
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->router = $router;
        $this->cacheManager = $cacheManager;
        $this->routeDependencies = $routeDependencies;
    }

    public function postUpdate(AdminInterface $admin, $object)
    {
        $this->invalidateEntity($object);
    }

    public function postPersist(AdminInterface $admin, $object)
    {
        $this->invalidateEntity($object);
    }

    public function postRemove(AdminInterface $admin, $object)
    {
        $this->invalidateEntity($object);
    }

    protected function invalidateEntity($entity)
    {
        $invalidations = [
            'app_homepage'
        ];

        try {
            $entityRoute = $this->urlGenerator->getRouteAndParameters($entity);
            $invalidations[] = $entityRoute;
            $entityRouteName = $entityRoute[0];
        } catch (\RuntimeException $e) {
        }

        if (!empty($entityRouteName)) {
            if ($entity instanceof Post) {
                $invalidations[] = $this->urlGenerator->getRouteAndParameters($entity->getCategory());
            } elseif (0 === substr_compare($entityRouteName, self::ROUTE_SHOW_POSTFIX, -strlen(self::ROUTE_SHOW_POSTFIX))) {
                $listRouteName = str_replace(self::ROUTE_SHOW_POSTFIX, self::ROUTE_LIST_POSTFIX, $entityRouteName);
                try {
                    $this->router->generate($listRouteName);
                    $invalidations[] = $listRouteName;
                } catch (RoutingExceptionInterface $e) {
                }
            }

            if (!empty($this->routeDependencies[$entityRouteName])) {
                $invalidations = array_merge($invalidations, $this->routeDependencies[$entityRouteName]);
            }
        }

        foreach ($invalidations as $invalidation) {
            $invalidation = (array)$invalidation;
            $this->cacheManager->invalidateRoute($invalidation[0], isset($invalidation[1]) ? $invalidation[1] : []);
        }
    }
}
