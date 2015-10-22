<?php

namespace Detail\Locale;

use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ControllerProviderInterface,
    ServiceProviderInterface
{
    public function onBootstrap(MvcEvent $event)
    {
        $this->bootstrapLocale($event);
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
        return include __DIR__ . '/../../../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return array();
    }

    public function getServiceConfig()
    {
        return array();
    }

    /**
     * @param MvcEvent $event
     */
    protected function bootstrapLocale(MvcEvent $event)
    {
        /** @var \Zend\ServiceManager\ServiceManager $serviceManager */
        $serviceManager = $event->getApplication()->getServiceManager();

//        /** @var \SlmLocale\Strategy\StrategyPluginManager $strategies */
//        $strategies = $serviceManager->get('SlmLocale\Strategy\StrategyPluginManager');
//
//        var_dump($strategies->getRegisteredServices());
    }
}
