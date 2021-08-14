<?php

namespace Test\Framework\Container;

use Framework\Container\Container;
use Framework\Container\Exception\ServiceNotFoundException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public $backupStaticAttributes = false;
    public $runTestInSeparateProcess = true;

    public function testPrimitives(): void
    {
        $container = new Container();

        $container->set($name = 'Number_service', $value = 5);
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'String_service', $value = 'Good');
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'Array_service', $value = ['Good', 'Better']);
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'Object_service', $value = new \stdClass());
        self::assertEquals($value, $container->get($name));
    }

    public function testCallback(): void
    {
        $container = new Container();

        $container->set($name = 'Std_service', function () {
            return new \stdClass();
        });

        self::assertNotNull($value = $container->get($name));
        self::assertInstanceOf(\stdClass::class, $value);
    }

    public function testNotFound():void
    {
        $container = new Container();

        $this->expectException(ServiceNotFoundException::class);

        $container->get('Email_service');
    }
}
