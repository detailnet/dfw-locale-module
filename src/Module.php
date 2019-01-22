<?php

namespace Detail\Locale;

//use Locale;

use SlmLocale;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Router\SimpleRouteStack;
use Zend\ServiceManager\ServiceManager;

use Detail\Locale\Mvc\MvcEventAwareInterface;
use Detail\Locale\Options\ModuleOptions;
use Detail\Locale\Strategy;

class Module implements
    ConfigProviderInterface
{
    /**
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $this->bootstrapStrategies($event);
        $this->bootstrapSlmLocale($event);
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @param MvcEvent $event
     */
    protected function bootstrapSlmLocale(MvcEvent $event)
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $event->getApplication()->getServiceManager();

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $serviceManager->get(ModuleOptions::CLASS);

        if ($serviceManager->has(SlmLocale\Locale\Detector::CLASS)) {
            /** @var SlmLocale\Locale\Detector $detector */
            $detector = $serviceManager->get(SlmLocale\Locale\Detector::CLASS);

            foreach ($moduleOptions->getListeners() as $listenerClass) {
                if (!$serviceManager->has($listenerClass)) {
                    throw new Exception\ConfigException(
                        sprintf(
                            'Invalid listener class "%s" specified; must be a valid class name',
                            $listenerClass
                        )
                    );
                }

                $listener = $serviceManager->get($listenerClass);

                if (!$listener instanceof ListenerAggregateInterface) {
                    throw new Exception\ConfigException(
                        sprintf(
                            'Invalid listener class "%s" specified; must be an instance of "%s"',
                            $listenerClass,
                            ListenerAggregateInterface::CLASS
                        )
                    );
                }

                $listener->attach($detector->getEventManager());
            }
        }

//        /**
//         * @param MvcEvent $event
//         * @return ResponseInterface|null
//         */
//        $detectLocale = function(MvcEvent $event) use ($services) {
//            var_dump($services);
//
//            /** @var SlmLocale\Locale\Detector $detector */
//            $detector = $services->get('SlmLocale\Locale\Detector');
//            $result   = $detector->detect($event->getRequest(), $event->getResponse());
//
//            if ($result instanceof ResponseInterface) {
//                return $result;
//            }
//
//            Locale::setDefault($result);
//            return null;
//        };
//
//        $events = $event->getApplication()->getEventManager();
//        $events->attach(MvcEvent::EVENT_ROUTE, $detectLocale, 0); // Just after the route has been matched

        $slmModule = new SlmLocale\Module();
        $slmModule->onBootstrap($event);
    }

    /**
     * @param MvcEvent $event
     */
    protected function bootstrapStrategies(MvcEvent $event)
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $event->getApplication()->getServiceManager();

        // Use our own extended versions of UriPathStrategy and CookieStrategy
        if ($serviceManager->has('SlmLocale\Strategy\StrategyPluginManager')) {
            /** @var SimpleRouteStack $router */
            $router = $serviceManager->get('router');

            /** @var SlmLocale\Strategy\StrategyPluginManager $plugins */
            $plugins = $serviceManager->get(SlmLocale\Strategy\StrategyPluginManager::CLASS);
            $plugins->setInvokableClass('cookie', Strategy\CookieStrategy::CLASS);
            $plugins->setFactory('uripath', function () use ($router) {
                return new Strategy\UriPathStrategy($router);
            });

            // We may need to inject the MvcEvent into a Strategy
            $plugins->addInitializer(
                function ($strategy) use ($event) {
                    if ($strategy instanceof MvcEventAwareInterface) {
                        $strategy->setMvcEvent($event);
                    }
                }
            );
        }
    }
}
