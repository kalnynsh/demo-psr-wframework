<?php

namespace Test\Framework\Container;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;

class ContainerMock implements ContainerInterface
{
    /**
     * @param class-string $id
     *
     * @throws ServiceNotFoundException
     *
     * @return mixed
    */
    public function get(string $id)
    {
        if (! \class_exists($id)) {
            throw new ServiceNotFoundException('Service ' . $id . ' not exists.');
        }

        return new $id();
    }

    /**
     * @param class-string $id
     * @return bool
    */
    public function has(string $id): bool
    {
        return \class_exists($id);
    }
}
