<?php

namespace DetailTest\Locale;

use PHPUnit\Framework\TestCase;

use Detail\Locale\Module;

class ModuleTest extends TestCase
{
    /**
     * @var Module
     */
    protected $module;

    protected function setUp()
    {
        $this->module = new Module();
    }

    public function testModuleProvidesConfig()
    {
        $config = $this->module->getConfig();

        $this->assertTrue(is_array($config));
        $this->assertArrayHasKey('detail_locale', $config);
        $this->assertTrue(is_array($config['detail_locale']));
    }
}
