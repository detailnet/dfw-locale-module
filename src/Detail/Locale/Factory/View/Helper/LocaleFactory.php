<?php

namespace Detail\Locale\Factory\View\Helper;

use Zend\I18n\Translator\Translator;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

use Detail\Locale\View\Helper\Locale as Helper;

class LocaleFactory
    implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $pluginManager
     * @return Helper
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        /** @var \Zend\View\HelperPluginManager $pluginManager */

        /** @var Translator $translator */
        $translator = $pluginManager->getServiceLocator()->get('translator');

        $helper = new Helper();
        $helper->setTranslator($translator);

        return $helper;
    }
}
