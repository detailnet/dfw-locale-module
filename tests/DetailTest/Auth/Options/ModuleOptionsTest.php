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
                'getAuthorization',
                'setAuthorization',
            )
        );
    }

    public function testOptionsExist()
    {
        $this->assertInstanceOf('Detail\Locale\Options\ModuleOptions', $this->options);
    }

    public function testAuthorizationCanBeSet()
    {
        $this->assertNull($this->options->getAuthorization());

        $this->options->setAuthorization(array());

        $authorization = $this->options->getAuthorization();

        $this->assertInstanceOf('Detail\Locale\Options\Authorization\AuthorizationOptions', $authorization);
    }
}
