<?php
namespace AppBundle\Routing;

use AppBundle\Entity\Category;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class PostCategoryRouteLoader extends Loader
{
    private $loaded = false;

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "custom_post_list_route_loader" loader twice');
        }

        $routes = new RouteCollection();

        foreach (Category::$categories as $alias => $title) {
            $route = new Route("/$alias", [
                '_controller' => 'AppBundle:Post:list',
                'categoryAlias' => $alias,
            ]);
            $routes->add(PostCategoryRouteName::generate($alias, PostCategoryRouteName::TYPE_LIST), $route);

            if (!empty(Category::$hasPopularPage[$alias])) {
                $route = new Route("/$alias/popular", [
                    '_controller' => 'AppBundle:Post:list',
                    'categoryAlias' => $alias,
                    'popular' => true,
                ]);
                $routes->add(PostCategoryRouteName::generate($alias, PostCategoryRouteName::TYPE_LIST_POPULAR), $route);
            }

            $route = new Route("/{categoryAlias}/{slug}", [
                '_controller' => 'AppBundle:Post:show',
            ], [
                'categoryAlias' => $alias,
                'slug' => '[a-zA-z_\/0-9-]+',
            ]);
            $routes->add(PostCategoryRouteName::generate($alias, PostCategoryRouteName::TYPE_SHOW), $route);
        }

        $route = new Route('/{categoryAlias}', [
            '_controller' => 'AppBundle:Post:list',
        ], [
            'categoryAlias' => implode('|', array_keys(Category::$categories))
        ]);
        $routes->add(PostCategoryRouteName::COMMON_POST_LIST, $route);

        $route = new Route('/{categoryAlias}/{slug}', [
            '_controller' => 'AppBundle:Post:show',
        ], [
            'categoryAlias' => implode('|', array_keys(Category::$categories)),
            'slug' => '[a-zA-z_\/0-9-]+',
        ]);
        $routes->add(PostCategoryRouteName::COMMON_POST_SHOW, $route);

        $this->loaded = true;

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'post_category_route' === $type;
    }
}
