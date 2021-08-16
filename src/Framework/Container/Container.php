<?php

namespace Framework\Container;

use Framework\Container\Exception\ServiceNotFoundException;

class Container
{
    private array $definitions = [];
    private array $results = [];

    /** @param class-string|string $id */
    public function get($id)
    {
        if (\array_key_exists($id, $this->results)) {
            return $this->results[$id];
        }

        if (! \array_key_exists($id, $this->definitions)) {

            if (class_exists($id)) {
                return $this->results[$id] = new $id();
            }

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

    /** @param class-string|string $id */
    public function has($id): bool
    {
        return array_key_exists($id, $this->definitions)
            || class_exists($id);
    }

    public function set($id, $value): void
    {
        $this->definitions[$id] = $value;
    }
}
