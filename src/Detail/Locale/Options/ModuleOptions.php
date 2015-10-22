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
}
