<?php

namespace Detail\Locale;

//use Locale;

use SlmLocale;

use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;
//use Zend\Stdlib\ResponseInterface;

use Detail\Locale\Mvc\MvcEventAwareInterface;
use Detail\Locale\Options\ModuleOptions;
use Detail\Locale\Strategy;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ControllerProviderInterface,
    ServiceProviderInterface
{
    /**
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $this->bootstrapStrategies($event);
        $this->bootstrapSlmLocale($event);
    }

    /**
     * {@inheritdoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        /** @todo We should merge with SlmLocale's config */
        return include __DIR__ . '/../../../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getControllerConfig()
    {
        return array();
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array();
    }

    /**
     * @param MvcEvent $event
     */
    protected function bootstrapSlmLocale(MvcEvent $event)
    {
        $services = $event->getApplication()->getServiceManager();

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $services->get(ModuleOptions::CLASS);

        if ($services->has(SlmLocale\Locale\Detector::CLASS)) {
            /** @var SlmLocale\Locale\Detector $detector */
            $detector = $services->get(SlmLocale\Locale\Detector::CLASS);

            foreach ($moduleOptions->getListeners() as $listenerClass) {
                if (!$services->has($listenerClass)) {
                    throw new Exception\ConfigException(
                        sprintf(
                            'Invalid listener class "%s" specified; must be a valid class name',
                            $listenerClass
                        )
                    );
                }

                $detector->getEventManager()->attach(
                    $services->get($listenerClass)
                );
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
        /** @var \Zend\ServiceManager\ServiceManager $services */
        $services = $event->getApplication()->getServiceManager();

        // Use our own extended versions of UriPathStrategy and CookieStrategy
        if ($services->has('SlmLocale\Strategy\StrategyPluginManager')) {
            /** @var \SlmLocale\Strategy\StrategyPluginManager $plugins */
            $plugins = $services->get(SlmLocale\Strategy\StrategyPluginManager::CLASS);
            $plugins->setInvokableClass('uripath', Strategy\UriPathStrategy::CLASS);
            $plugins->setInvokableClass('cookie', Strategy\CookieStrategy::CLASS);

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
