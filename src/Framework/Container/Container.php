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

        $definition =  $this->definitions[$id];

        if ($definition instanceof \Closure) {
            return $definition();
        }

        return $definition;
    }

    public function set($id, $value): void
    {
        $this->definitions[$id] = $value;
    }
}
