<?php

namespace Detail\Locale\Options;

use Detail\Core\Options\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $navigationItems = array();

    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * @return array
     */
    public function getNavigationItems()
    {
        return $this->navigationItems;
    }

    /**
     * @param array $navigationItems
     */
    public function setNavigationItems(array $navigationItems)
    {
        $this->navigationItems = $navigationItems;
    }

    /**
     * @return array
     */
    public function getListeners()
    {
        return $this->listeners;
    }

    /**
     * @param array $listeners
     */
    public function setListeners(array $listeners)
    {
        $this->listeners = $listeners;
    }
}
