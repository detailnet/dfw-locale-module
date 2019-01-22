<?php

namespace Detail\Locale\View\Helper;

use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\TranslatorAwareTrait;
use Zend\View\Helper\AbstractHelper;

class Locale extends AbstractHelper
{
    use TranslatorAwareTrait;

    /**
     * @return string
     */
    public function __invoke()
    {
        /** @var Translator $translator */
        $translator = $this->getTranslator();

        return $translator->getLocale();
    }
}
