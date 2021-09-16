<?php

namespace Framework\Template\Php;

class SimpleFunction
{
    public string $name;
    /** @var callable $callback */
    public $callback;
    public bool $needRendering;

    public function __construct(
        string $name,
        callable $callback,
        bool $needRendering = false
    ) {
        $this->name = $name;
        $this->callback = $callback;
        $this->needRendering = $needRendering;
    }
}
