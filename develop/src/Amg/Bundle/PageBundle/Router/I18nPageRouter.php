<?php

namespace Amg\Bundle\PageBundle\Router;

use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class I18nPageRouter
 * @package Amg\Bundle\PageBundle\Router
 * @todo Untested!
 */
class I18nPageRouter extends PageRouter
{
    protected $locales = [];

    protected $defaultLocale;

    protected $currentLocale;

    public function __construct(
        $routeName,
        $controller,
        RequestContext $context = null,
        $defaultLocale,
        $locales
    )
    {
        parent::__construct($routeName, $controller, $context);
        $this->locales = $locales;
        $this->defaultLocale = $defaultLocale;
    }

    protected function getLocale()
    {
        return $this->getContext()->hasParameter('_locale')
            ? $this->getContext()->getParameter('_locale')
            : $this->currentLocale;
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
            throw new RouteNotFoundException("Only 'page' route can be generated");
        }

        if (!isset($parameters['_locale'])) {
            $parameters['_locale'] = $this->getLocale();
        }

        if ($this->defaultLocale == $parameters['_locale']) {
            unset($parameters['_locale']);
        }

        if (!isset($parameters['_locale'])) {
            $name = $this->routeName . '_nolocale';
        }

        return $this->getUrlGenerator()->generate($name, $parameters, $referenceType);
    }

    /**
     * Create RouteCollection with page route for matcher and generator
     *
     * @return RouteCollection
     */
    protected function createRouteCollection()
    {
        if (!isset($this->routeCollection)) {
            $this->routeCollection = new RouteCollection();

            $this->routeCollection->add($this->routeName, new Route('/{_locale}/{slug}', [
                '_controller' => $this->controller,
            ], [
                '_locale' => implode('|', $this->locales),
                'slug' => '.*'
            ]));

            $this->routeCollection->add($this->routeName . '_nolocale', new Route('/{slug}', [
                '_controller' => $this->controller,
                '_locale' => $this->defaultLocale,
            ], [
                'slug' => '.*'
            ]));
        }

        return $this->routeCollection;
    }
}
