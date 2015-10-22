<?php

namespace Detail\Locale\Mvc;

use Zend\Mvc\MvcEvent;

interface MvcEventAwareInterface
{
    /**
     * @param MvcEvent $event
     * @return void
     */
    public function setMvcEvent(MvcEvent $event);

    /**
     * @return MvcEvent|null
     */
    public function getMvcEvent();
}
