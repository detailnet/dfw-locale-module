<?php

namespace DetailTest\Locale\Options;

use Detail\Locale\Options\ModuleOptions;

class ModuleOptionsTest extends OptionsTestCase
{
    /**
     * @var ModuleOptions
     */
    protected $options;

    protected function setUp()
    {
        $this->options = $this->getOptions(
            ModuleOptions::CLASS,
            [
                'getNavigationItems',
                'setNavigationItems',
                'getListeners',
                'setListeners',
            ]
        );
    }

    public function testOptionsExist()
    {
        $this->assertInstanceOf(ModuleOptions::CLASS, $this->options);
    }

    public function testNavigationItemsCanBeSet()
    {
        $this->assertEquals([], $this->options->getNavigationItems());

        $navigationItems = ['de_CH' => 'DE'];

        $this->options->setNavigationItems($navigationItems);

        $this->assertEquals($navigationItems, $this->options->getNavigationItems());
    }

    public function testListenersCanBeSet()
    {
        $this->assertEquals([], $this->options->getListeners());

        $listeners = ['Some\Listener\Class'];

        $this->options->setListeners($listeners);

        $this->assertEquals($listeners, $this->options->getListeners());
    }
}
