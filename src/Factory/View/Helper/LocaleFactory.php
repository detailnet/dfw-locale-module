<?php

namespace Detail\Locale\Factory\View\Helper;

use Interop\Container\ContainerInterface;

use Zend\I18n\Translator\Translator;
use Zend\ServiceManager\Factory\FactoryInterface;

use Detail\Locale\View\Helper\Locale as Helper;

class LocaleFactory implements
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
        /** @var Translator $translator */
        $translator = $container->get('translator');

        $helper = new Helper();
        $helper->setTranslator($translator);

        return $helper;
    }
}
