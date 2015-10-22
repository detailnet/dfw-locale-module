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
            array(
                'getNavigationItems',
                'setNavigationItems',
            )
        );
    }

    public function testOptionsExist()
    {
        $this->assertInstanceOf('Detail\Locale\Options\ModuleOptions', $this->options);
    }

    public function testNavigationItemsCanBeSet()
    {
        $this->assertEquals(array(), $this->options->getNavigationItems());

        $navigationItems = array('de_CH' => 'DE');

        $this->options->setNavigationItems($navigationItems);

        $this->assertEquals($navigationItems, $this->options->getNavigationItems());
    }
}
