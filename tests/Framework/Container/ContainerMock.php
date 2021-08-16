<?php

namespace Test\Framework\Container;

use Framework\Container\Container;
use Framework\Container\Exception\ServiceNotFoundException;

class ContainerMock extends Container
{
    /** @param class-string $id  */
    public function get($id): Object
    {
        if (! \class_exists($id)) {
            throw new ServiceNotFoundException('Service ' . $id . ' not exists.');
        }

        return new $id();
    }

    /** @param class-string $id  */
    public function has($id): bool
    {
        return \class_exists($id);
    }
}
