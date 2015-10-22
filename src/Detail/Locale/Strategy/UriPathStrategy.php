<?php

namespace Detail\Locale\Strategy;

use Zend\Http\Request as HttpRequest;
//use Zend\Mvc\Router\Http\RouteMatch;
//use Zend\Mvc\Router\Http\TreeRouteStack;


use SlmLocale\LocaleEvent;
use SlmLocale\Strategy\UriPathStrategy as BaseUriPathStrategy;

use Detail\Locale\Mvc\MvcEventAwareInterface;
use Detail\Locale\Mvc\MvcEventAwareTrait;

class UriPathStrategy extends BaseUriPathStrategy implements
    MvcEventAwareInterface
{
    use MvcEventAwareTrait;

    const OPTION_REDIRECT_WHEN_FOUND   = 'redirect_when_found';
    const OPTION_REDIRECT_TO_CANONICAL = 'redirect_to_canonical';
    const OPTION_ALIASES               = 'aliases';
    const OPTION_IGNORED_ROUTES        = 'ignored_routes';

    /**
     * @var array
     */
    protected $ignoredRoutes = array();

    /**
     * @return array
     */
    public function getIgnoredRoutes()
    {
        return $this->ignoredRoutes;
    }

    /**
     * @param array $ignoredRoutes
     */
    public function setIgnoredRoutes($ignoredRoutes)
    {
        $this->ignoredRoutes = $ignoredRoutes;
    }

    /**
     * @param string|null $routeName
     * @return boolean
     */
    public function isIgnoredRoute($routeName = null)
    {
        if ($routeName === null) {
            $routeName = $this->getMatchedRouteName();
        }

        if ($routeName === null) {
            return false;
        }

        foreach ($this->getIgnoredRoutes() as $routeRule) {
            if (fnmatch($routeRule, $routeName, FNM_CASEFOLD)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options = array())
    {
        parent::setOptions($options);

        if (array_key_exists(self::OPTION_IGNORED_ROUTES, $options)) {
            $this->setIgnoredRoutes((array) $options[self::OPTION_IGNORED_ROUTES]);
        }
    }

    /**
     * @param LocaleEvent $event
     * @return string|void
     */
    public function detect(LocaleEvent $event)
    {
        // Check if the route should be ignored before any detection takes place...
        if ($this->isIgnoredRoute()) {
            return null;
        }

        return parent::detect($event);
    }

    /**
     * @param LocaleEvent $event
     * @return string|void
     */
    public function found(LocaleEvent $event)
    {
        // Check if the route should be ignored before any finding takes place...
        if ($this->isIgnoredRoute()) {
            return null;
        }

        return parent::found($event);
    }


    /**
     * @return string
     */
    protected function getMatchedRouteName()
    {
        $mvcEvent = $this->getMvcEvent();

        if ($mvcEvent === null) {
            /** @todo Should probably throw an exception instead... */
            return null;
        }

        $request = $mvcEvent->getRequest();

        if (!$this->isHttpRequest($request)) {
            return null;
        }

        /** @var HttpRequest $request */

        $router = $mvcEvent->getRouter();

//        if (!$router instanceof TreeRouteStack) {
//            /** @todo Should probably throw an exception instead... */
//            return null;
//        }

//        $base  = $this->getBasePath();
//        $found = $this->getFirstSegmentInPath($request->getUri(), $base);
//
//        if ($found) {
//            $base .= '/' . $found;
//        }
//
//        $routeMatch = $router->match($request, strlen($base));

        $routeMatch = $router->match($request);

        if ($routeMatch === null) {
            return null;
        }

        return $routeMatch->getMatchedRouteName();
    }
}
