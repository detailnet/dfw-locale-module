<?php

namespace Detail\Locale\Factory\View\Helper;

use Zend\Mvc\Router\Http\RouteMatch;
use Zend\I18n\Translator\Translator;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

use Detail\Locale\Options\ModuleOptions;
use Detail\Locale\View\Helper\LocaleNavigation as Helper;

class LocaleNavigationFactory implements
    FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $pluginManager
     * @return Helper
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        /** @var \Zend\View\HelperPluginManager $pluginManager */

        $services = $pluginManager->getServiceLocator();

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $services->get(ModuleOptions::CLASS);

        /** @var Translator $translator */
        $translator = $services->get('translator');

        /** @var RouteMatch $route */
        $route = $services->get('Application')->getMvcEvent()->getRouteMatch();

        $helper = new Helper();
        $helper->setNavigationItems($moduleOptions->getNavigationItems());
        $helper->setTranslator($translator);

        if ($route) {
            $helper->setRoute($route->getMatchedRouteName());
            $helper->setParams($route->getParams());
        }

        return $helper;
    }
}
