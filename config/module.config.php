<?php

return array(
    'service_manager' => array(
        'abstract_factories' => array(
        ),
        'aliases' => array(
        ),
        'invokables' => array(
            'SlmLocale\Strategy\StrategyPluginManager' => 'SlmLocale\Strategy\StrategyPluginManager',
        ),
        'factories' => array(
            'SlmLocale\Locale\Detector' => 'SlmLocale\Service\DetectorFactory',
            'Detail\Locale\Options\ModuleOptions' => 'Detail\Locale\Factory\Options\ModuleOptionsFactory',
        ),
        'initializers' => array(
        ),
        'shared' => array(
        ),
    ),
    'view_helpers' => array(
        'aliases' => array(
//            'localeMenu' => 'SlmLocale\View\Helper\LocaleMenu',
            'localeUrl' => 'SlmLocale\View\Helper\LocaleUrl',
            'locale' => 'Detail\Locale\View\Helper\Locale',
            'localeNavigation' => 'Detail\Locale\View\Helper\LocaleNavigation',

        ),
        'factories' => array(
//            'SlmLocale\View\Helper\LocaleMenu' => 'SlmLocale\Service\LocaleMenuViewHelperFactory',
            'SlmLocale\View\Helper\LocaleUrl'=> 'SlmLocale\Service\LocaleUrlViewHelperFactory',
            'Detail\Locale\View\Helper\Locale' => 'Detail\Locale\Factory\View\Helper\LocaleFactory',
            'Detail\Locale\View\Helper\LocaleNavigation' => 'Detail\Locale\Factory\View\Helper\LocaleNavigationFactory',
        ),
    ),
    'slm_locale' => array(
        /**
         * Default locale.
         */
//        'default' => 'en_US',

        /**
         * Supported locales.
         */
//        'supported' => array('en_US'),

        /**
         * Detection strategies.
         */
        'strategies' => array(),
    ),
    'detail_locale' => array(
        'navigation_items' => array(),
        'listeners' => array(),
    ),
);
