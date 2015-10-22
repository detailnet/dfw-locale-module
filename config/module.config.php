<?php

return array(
    'service_manager' => array(
        'abstract_factories' => array(
        ),
        'aliases' => array(
        ),
        'invokables' => array(
        ),
        'factories' => array(
            'Detail\Locale\Options\ModuleOptions' => 'Detail\Locale\Factory\Options\ModuleOptionsFactory',
        ),
        'initializers' => array(
        ),
        'shared' => array(
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'localeNavigation' => 'Detail\Locale\Factory\View\Helper\LocaleNavigationFactory',
            'locale' => 'Detail\Locale\Factory\View\Helper\LocaleFactory',
        )
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
//        'strategies' => array(),
    ),
    'detail_locale' => array(
        'navigation_items' => array(),
    ),
);
