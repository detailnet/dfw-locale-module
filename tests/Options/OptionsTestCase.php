<?php

namespace DetailTest\Locale\Options;

use ReflectionClass;
use ReflectionMethod;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class OptionsTestCase extends TestCase
{
    /**
     * @param string $class
     * @param array $methods
     * @return MockObject
     */
    protected function getOptions($class, array $methods)
    {
        $mockedMethods = array_diff($this->getMethods($class), $methods);

        return $this->getMockBuilder($class)->setMethods($mockedMethods)->getMock();
    }

    /**
     * Helper to get all public and abstract methods of a class.
     *
     * This includes methods of parent classes.
     *
     * @param string $class
     * @param bool $autoload
     * @return array
     */
    protected function getMethods($class, $autoload = true)
    {
        $methods = [];

        if (class_exists($class, $autoload) || interface_exists($class, $autoload)) {
            $reflector = new ReflectionClass($class);

            foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_ABSTRACT) as $method) {
                $methods[] = $method->getName();
            }
        }

        return $methods;
    }
}
