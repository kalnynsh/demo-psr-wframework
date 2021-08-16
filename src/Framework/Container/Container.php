<?php

namespace Framework\Container;

use Framework\Container\Exception\ServiceNotFoundException;

class Container
{
    private array $definitions = [];
    private array $results = [];

    public function get($id)
    {
        if (\array_key_exists($id, $this->results)) {
            return $this->results[$id];
        }

        if (! \array_key_exists($id, $this->definitions)) {
            throw new ServiceNotFoundException('Unknown service "' . $id . '"');
        }

        $definition =  $this->definitions[$id];

        if ($definition instanceof \Closure) {
            $this->results[$id] = $definition($this);
        } else {
            $this->results[$id] = $definition;
        }

        return $this->results[$id];
    }

    public function has($id): bool
    {
        return array_key_exists($id, $this->definitions);
    }

    public function set($id, $value): void
    {
        $this->definitions[$id] = $value;
    }
}
