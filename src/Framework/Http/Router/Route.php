<?php

namespace Framework\Http\Router;

class Route
{
    public string $name;
    public string $pattern;
    public $handler; 
    public array $methods; 
    public array $tokens;

    public function __construct(
        string $name, 
        string $pattern, 
        $handler, 
        array $methods, 
        array $tokens = []
    ) {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->handler = $handler; 
        $this->methods = $methods;
        $this->tokens = $tokens;        
    }
}
