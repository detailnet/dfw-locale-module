<?php

namespace Detail\Locale\Factory\View\Helper;

use Interop\Container\ContainerInterface;

use Zend\I18n\Translator\Translator;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteMatch;
use Zend\ServiceManager\Factory\FactoryInterface;

use Detail\Locale\Options\ModuleOptions;
use Detail\Locale\View\Helper\LocaleNavigation as Helper;

class LocaleNavigationFactory implements
    FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Helper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::CLASS);

        /** @var Translator $translator */
        $translator = $container->get('translator');

        /** @var MvcEvent $mvcEvent */
        $mvcEvent = $container->get('Application')->getMvcEvent();
        $routeMatch = $mvcEvent->getRouteMatch();

        $helper = new Helper();
        $helper->setNavigationItems($moduleOptions->getNavigationItems());
        $helper->setTranslator($translator);

        if ($routeMatch instanceof RouteMatch) {
            $helper->setRoute($routeMatch->getMatchedRouteName());
            $helper->setRouteParams($routeMatch->getParams());
        }

        return $helper;
    }
}
