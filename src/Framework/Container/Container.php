<?php

namespace Framework\Container;

use Framework\Container\Exception\ServiceNotFoundException;

class Container
{
    private array $definitions = [];

    public function get($id)
    {
        if (! array_key_exists($id, $this->definitions)) {
            throw new ServiceNotFoundException('Unknown service "' . $id . '"');
        }

        return $this->definitions[$id];
    }

    public function set($id, $value): void
    {
        $this->definitions[$id] = $value;
    }
}
