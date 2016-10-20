<?php

namespace Detail\Locale\Factory\SlmLocale;

use Zend\Mvc\Service\AbstractPluginManagerFactory;

use SlmLocale\Strategy\StrategyPluginManager;

class StrategyPluginManagerFactory extends AbstractPluginManagerFactory
{
    const PLUGIN_MANAGER_CLASS = StrategyPluginManager::CLASS;
}
