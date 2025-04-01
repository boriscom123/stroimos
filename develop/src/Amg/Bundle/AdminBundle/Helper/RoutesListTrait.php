<?php
namespace Amg\Bundle\AdminBundle\Helper;

use Sonata\AdminBundle\Admin\Pool;

trait RoutesListTrait
{
    /**
     * @return Pool
     */
    abstract public function getConfigurationPool();

    protected function getRoutesNameList()
    {
        if (empty($this->routesNameList)) {
            $router = $this->getConfigurationPool()->getContainer()->get("router");
            $routeCollection = $router->getRouteCollection()->all();
            $routes = array();
            foreach ($routeCollection as $name => $route) {
                foreach(['admin_', 'sonata_', 'fos_', 'api_', '_'] as $exclude) {
                    if (0 === strpos($name, $exclude)) {
                        continue 2;
                    }
                }

                $routes[$name] = $name;
            }
            asort($routes);
            $this->routesNameList = $routes;
        }
        return $this->routesNameList;
    }
}