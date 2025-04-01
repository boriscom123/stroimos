<?php
namespace AppBundle\Routing;

use AppBundle\Entity\Category;
use AppBundle\Entity\Owner;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class SubordinateRouteLoader extends Loader
{
    private $config = [
        'news' => [
            '_controller' => 'AppBundle:Subordinate:postsList',
            'categoryAlias' => 'news'
        ],
        'press_releases' => [
            '_controller' => 'AppBundle:Subordinate:postsList',
            'categoryAlias' => 'press_releases'
        ],
        'documents' => [
            '_controller' => 'AppBundle:Subordinate:documentsList',
        ],
        'publications' => [
            '_controller' => 'AppBundle:Subordinate:publicationsList',
        ],
        'shorthand-reports' => [
            '_controller' => 'AppBundle:Subordinate:shorthandReportsList',
        ]
    ];

    private $loaded = false;

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "subordinate_route_loader" loader twice');
        }

        $routes = new RouteCollection();

        foreach (Owner::$organizations as $organization) {
            foreach ($this->config as $key => $value) {
                $route = new Route(sprintf('/structure/%s/%s', $organization, $key), $value);
                $routes->add(sprintf('app_subordinate_%s_%s', $organization, $key), $route);
            }

            /**
             * Добавляем маршруты для главных страниц департаментов
             */
            $route = new Route(
                sprintf('/structure/%s', $organization),
                [
                    '_controller' => 'AppBundle:Subordinate:homePage',
                ]
            );
            $routes->add(sprintf('app_subordinate_%s_homepage', $organization), $route);
        }

        /**
         * Добавляем маршруты для страниц просмотра постов (все публикации кроме новостей) для каждого департамента
         */
        $categories = Category::$categories;
        unset($categories[Category::CATEGORY_NEWS]);
        $route = new Route(
            '/structure/{organization}/{categoryAlias}/{slug}',
            [
                '_controller' => 'AppBundle:Subordinate:postShow',
            ],
            [
                'organization' => implode('|', Owner::$organizations),
                'categoryAlias' => implode('|', array_keys($categories)),
                'slug' => '[a-zA-z_\/0-9-]+'
            ]
        );
        $routes->add('app_subordinate_post_show', $route);

        /**
         * Добавляем маршруты для страниц просмотра новостей для каждого департамента
         */
        $route = new Route(
            '/structure/{organization}/news/{slug}',
            [
                '_controller' => 'AppBundle:Subordinate:postShow',
            ],
            [
                'organization' => implode('|', Owner::$organizations),
                'slug' => '[a-zA-z_\/0-9-]+'
            ]
        );
        $routes->add('app_subordinate_news_show', $route);

        /**
         * Добавляем маршруты для страниц просмотра постов для каждого департамента
         */
        $route = new Route(
            '/structure/{organization}/video/{id}',
            [
                '_controller' => 'AppBundle:Subordinate:videoShow',
            ],
            [
                'organization' => implode('|', Owner::$organizations),
                'id' => '\d+'
            ]
        );
        $routes->add('app_subordinate_video_show', $route);

        $this->loaded = true;

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'subordinate_route' === $type;
    }
}
