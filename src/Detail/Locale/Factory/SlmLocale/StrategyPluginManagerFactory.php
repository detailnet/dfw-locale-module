<?php

namespace Detail\Locale\Factory\SlmLocale;

use SlmLocale\Strategy\StrategyPluginManager;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StrategyPluginManagerFactory implements
    FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return StrategyPluginManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $strategies = new StrategyPluginManager();
        $strategies->setServiceLocator($serviceLocator);

        return $strategies;
    }
}
