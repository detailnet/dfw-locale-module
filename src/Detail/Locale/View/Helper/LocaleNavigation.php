<?php

namespace Detail\Locale\View\Helper;

use Zend\I18n\Translator\TranslatorAwareTrait;
use Zend\View\Helper\AbstractHelper;

class LocaleNavigation extends AbstractHelper
{
    use TranslatorAwareTrait;

    /**
     * @var array
     */
    protected $navigationItems = array();

    /**
     * @var null|string
     */
    protected $route;

    /**
     * @var array
     */
    protected $params = array();

    /**
     * @return string
     */
    public function __invoke()
    {
        $output = array();

        $currentLocale = $this->getView()->locale();

        foreach ($this->getNavigationItems() as $key => $label) {
            $url = $this->getView()->localeUrl($key, $this->getRoute() ? $this->getRoute() : 'home', $this->getParams());
            $label = $this->getView()->translate($label);

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
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
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
