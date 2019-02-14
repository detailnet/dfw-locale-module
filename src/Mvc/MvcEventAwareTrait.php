<?php

namespace Detail\Locale\Mvc;

use Zend\Mvc\MvcEvent;

trait MvcEventAwareTrait
{
    /**
     * @var MvcEvent|null
     */
    protected $mvcEvent;

    /**
     * @param MvcEvent $event
     * @return void
     */
    public function setMvcEvent(MvcEvent $event)
    {
        $this->mvcEvent = $event;
    }

    /**
     * @return MvcEvent|null
     */
    public function getMvcEvent()
    {
        return $this->mvcEvent;
    }
}
