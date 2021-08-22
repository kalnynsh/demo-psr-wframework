<?php

namespace Framework\Container;

use Framework\Container\Exception\ServiceNotFoundException;

interface ContainerInterface
{
    /**
     * @param $id
     * @return mixed
     * @throws ServiceNotFoundException
     */
    public function get($id);

    public function has($id): bool;
}
