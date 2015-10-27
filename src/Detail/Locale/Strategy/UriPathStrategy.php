<?php

namespace Detail\Locale\Strategy;

use Zend\Http\Request as HttpRequest;
//use Zend\Mvc\Router\Http\RouteMatch;
//use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\Stdlib\ResponseInterface;

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
    const OPTION_METHODS               = 'methods';

    /**
     * @var array
     */
    protected $ignoredRoutes = array();

    /**
     * Enabled request methods.
     *
     * Be careful when enabling methods other than GET.
     * The request may be redirected to GET.
     *
     * @var array
     */
    protected $methods = array('GET');

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
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     */
    public function setMethods(array $methods)
    {
        $uppercaseMethods = array();

        foreach ($methods as $method) {
            $uppercaseMethods[] = strtoupper($method);
        }

        $this->methods = $uppercaseMethods;
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
     * @param HttpRequest $request
     * @return boolean
     */
    public function isHttpRequestMethodEnabled(HttpRequest $request)
    {
        $methods = $this->getMethods();
        $isMethodEnabled = (
            count($methods) === 0
            || in_array(strtoupper($request->getMethod()), $methods)
        );

        return $isMethodEnabled;
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

        if (array_key_exists(self::OPTION_METHODS, $options)) {
            $this->setMethods((array) $options[self::OPTION_METHODS]);
        }
    }

    /**
     * @param LocaleEvent $event
     * @return string|void
     */
    public function detect(LocaleEvent $event)
    {
        if (!$this->isEnabled($event)) {
            return null;
        }

        return parent::detect($event);
    }

    /**
     * @param LocaleEvent $event
     * @return ResponseInterface|void
     */
    public function found(LocaleEvent $event)
    {
        if (!$this->isEnabled($event)) {
            return null;
        }

        return parent::found($event);
    }

    /**
     * @param LocaleEvent $event
     * @return boolean
     */
    protected function isEnabled(LocaleEvent $event)
    {
        // Check if the route should be ignored...
        if ($this->isIgnoredRoute()) {
            return false;
        }

        $request = $event->getRequest();

        if (!$this->isHttpRequest($request)
            || !$this->isHttpRequestMethodEnabled($request)
        ) {
            return false;
        }

        return true;
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
