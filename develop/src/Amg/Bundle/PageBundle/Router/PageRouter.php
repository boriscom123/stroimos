<?php

namespace Amg\Bundle\PageBundle\Router;

use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

class PageRouter implements RouterInterface, RequestMatcherInterface
{
    /**
     * @var RequestContext
     */
    protected $context;

    protected $routeName;

    protected $controller;

    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    public function __construct($routeName, $controller, RequestContext $context = null)
    {
        $this->routeName = $routeName;
        $this->controller = $controller;
        $this->context = $context ?: new RequestContext();
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Gets the RouteCollection instance associated with this Router.
     *
     * @return RouteCollection A RouteCollection instance
     */
    public function getRouteCollection()
    {
        if (!$this->routeCollection instanceof RouteCollection) {
            $this->routeCollection = $this->createRouteCollection();
        }

        return $this->routeCollection;
    }

    /**
     * Generates a URL or path for a specific route based on the given parameters.
     *
     * Parameters that reference placeholders in the route pattern will substitute them in the
     * path or host. Extra params are added as query string to the URL.
     *
     * When the passed reference type cannot be generated for the route because it requires a different
     * host or scheme than the current one, the method will return a more comprehensive reference
     * that includes the required params. For example, when you call this method with $referenceType = ABSOLUTE_PATH
     * but the route requires the https scheme whereas the current scheme is http, it will instead return an
     * ABSOLUTE_URL with the https scheme and the current host. This makes sure the generated URL matches
     * the route in any case.
     *
     * If there is no route with the given name, the generator must throw the RouteNotFoundException.
     *
     * @param string $name The name of the route
     * @param mixed $parameters An array of parameters
     * @param Boolean|string $referenceType The type of reference to be generated (one of the constants)
     *
     * @return string The generated URL
     *
     * @throws RouteNotFoundException              If the named route doesn't exist
     * @throws MissingMandatoryParametersException When some parameters are missing that are mandatory for the route
     * @throws InvalidParameterException           When a parameter value for a placeholder is not correct because
     *                                             it does not match the requirement
     *
     * @api
     */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        if ($name !== $this->routeName) {
            throw new RouteNotFoundException("Only '{$this->routeName}' route can be generated");
        }

        return $this->getUrlGenerator()->generate($name, $parameters, $referenceType);
    }

    /**
     * Tries to match a request with a set of routes.
     *
     * If the matcher can not find information, it must throw one of the exceptions documented
     * below.
     *
     * @param Request $request The request to match
     *
     * @return array An array of parameters
     *
     * @throws ResourceNotFoundException If no matching resource could be found
     * @throws MethodNotAllowedException If a matching resource was found but the request method is not allowed
     */
    public function matchRequest(Request $request)
    {
        $match = $this->getUrlMatcher()->match($request->getPathInfo());

        $match['_route'] = $this->routeName;

        return $match;
    }

    /**
     * Tries to match a URL path with a set of routes.
     *
     * If the matcher can not find information, it must throw one of the exceptions documented
     * below.
     *
     * @param string $pathinfo The path info to be parsed (raw format, i.e. not urldecoded)
     *
     * @return array An array of parameters
     *
     * @throws ResourceNotFoundException If the resource could not be found
     * @throws MethodNotAllowedException If the resource was found but the request method is not allowed
     *
     * @api
     */
    public function match($pathinfo)
    {
        return $this->matchRequest(Request::create($pathinfo));
    }

    /**
     * Create RouteCollection with page route for matcher and generator
     *
     * @return RouteCollection
     */
    protected function createRouteCollection()
    {
        $this->routeCollection = new RouteCollection();

        $this->routeCollection->add($this->routeName, new Route('/{slug}', ['_controller' => $this->controller], ['slug' => '.*']));

        return $this->routeCollection;
    }

    /**
     * @return UrlGenerator
     */
    protected function getUrlGenerator()
    {
        if (!isset($this->getUrlGenerator)) {
            $this->getUrlGenerator  = new UrlGenerator($this->getRouteCollection(), $this->getContext());
        }

        return $this->getUrlGenerator;
    }

    /**
     * @return UrlMatcher
     */
    protected function getUrlMatcher()
    {
        if (!isset($this->getUrlMatcher)) {
            $this->getUrlMatcher = new UrlMatcher($this->getRouteCollection(), $this->getContext());
        }

        return $this->getUrlMatcher;
    }
}
