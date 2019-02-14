<?php

return [
    'service_manager' => [
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'invokables' => [
        ],
        'factories' => [
            'SlmLocale\Locale\Detector' => 'SlmLocale\Service\DetectorFactory',
            'SlmLocale\Strategy\StrategyPluginManager' => 'Detail\Locale\Factory\SlmLocale\StrategyPluginManagerFactory',
            'Detail\Locale\Options\ModuleOptions' => 'Detail\Locale\Factory\Options\ModuleOptionsFactory',
        ],
        'initializers' => [
        ],
        'shared' => [
        ],
    ],
    'view_helpers' => [
        'aliases' => [
//            'localeMenu' => 'SlmLocale\View\Helper\LocaleMenu',
            'localeUrl' => 'SlmLocale\View\Helper\LocaleUrl',
            'locale' => 'Detail\Locale\View\Helper\Locale',
            'localeNavigation' => 'Detail\Locale\View\Helper\LocaleNavigation',

        ],
        'factories' => [
//            'SlmLocale\View\Helper\LocaleMenu' => 'SlmLocale\Service\LocaleMenuViewHelperFactory',
            'SlmLocale\View\Helper\LocaleUrl'=> 'SlmLocale\Service\LocaleUrlViewHelperFactory',
            'Detail\Locale\View\Helper\Locale' => 'Detail\Locale\Factory\View\Helper\LocaleFactory',
            'Detail\Locale\View\Helper\LocaleNavigation' => 'Detail\Locale\Factory\View\Helper\LocaleNavigationFactory',
        ],
    ],
    'slm_locale' => [
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
        'strategies' => [],
    ],
    'detail_locale' => [
        'navigation_items' => [],
        'listeners' => [],
    ],
];
