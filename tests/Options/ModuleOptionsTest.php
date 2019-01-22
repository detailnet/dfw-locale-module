<?php

namespace DetailTest\Locale\Options;

class ModuleOptionsTest extends OptionsTestCase
{
    /**
     * @var \Detail\Locale\Options\ModuleOptions
     */
    protected $options;

    protected function setUp()
    {
        $this->options = $this->getOptions(
            'Detail\Locale\Options\ModuleOptions',
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
        $this->assertInstanceOf('Detail\Locale\Options\ModuleOptions', $this->options);
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
