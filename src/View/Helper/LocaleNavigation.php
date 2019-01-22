<?php

namespace Detail\Locale\View\Helper;

use SlmLocale\View\Helper\LocaleUrl;

use Zend\I18n\Translator\TranslatorAwareTrait;
use Zend\I18n\View\Helper\Translate;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\PhpRenderer;

class LocaleNavigation extends AbstractHelper
{
    use TranslatorAwareTrait;

    /**
     * @var array
     */
    protected $navigationItems = [];

    /**
     * @var null|string
     */
    protected $route;

    /**
     * @var array
     */
    protected $routeParams = [];

    /**
     * @return string
     */
    public function __invoke()
    {
        $output = [];

        /** @var PhpRenderer $view */
        $view = $this->getView();

        /** @var Locale $localeHelper */
        $localeHelper = $view->plugin('locale');

        /** @var LocaleUrl $localeUrlHelper */
        $localeUrlHelper = $view->plugin('localeUrl');

        /** @var Translate $translateHelper */
        $translateHelper = $view->plugin('translate');

        $currentLocale = $localeHelper();

        foreach ($this->getNavigationItems() as $key => $label) {
            $url = $localeUrlHelper($key, $this->getRoute() ? $this->getRoute() : 'home', $this->getRouteParams());
            $label = $translateHelper($label);

            $output[] = '<a' . ($currentLocale === $key ? ' class="active"' : '') . ' href="' . $url . '">' . $label . '</a>';
        }

        if (count($output)) {
            return implode('&nbsp;', $output);
        }

        return null;
    }

    /**
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return null|string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return array
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }

    /**
     * @param array $params
     */
    public function setRouteParams(array $params)
    {
        $this->routeParams = $params;
    }

    /**
     * @return array
     */
    public function getNavigationItems()
    {
        return $this->navigationItems;
    }

    /**
     * @param array $navigationItems
     */
    public function setNavigationItems($navigationItems)
    {
        $this->navigationItems = $navigationItems;
    }
}
