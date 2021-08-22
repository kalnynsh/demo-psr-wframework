<?php

namespace Framework\Http\Router;

class RouteDto
{
    private string $name;
    private string $path;
    private string $handler;

    /** @var list<string> */
    private array $methods;

    /** @var array<array-key, mixed> */
    private array $options;

    public function __construct(
        string $name,
        string $path,
        string $handler,
        array $methods,
        array $options
    ) {
       $this->name = $name;
       $this->path = $path;
       $this->handler = $handler;
       $this->methods = \array_map('mb_strtoupper', $methods);
       $this->options = $options;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of path
     */ 
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the value of handler
     */ 
    public function getHandler(): string
    {
        return $this->handler;
    }

    /**
     * Get the value of methods
     */ 
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * Get the value of options
     */ 
    public function getOptions(): array
    {
        return $this->options;
    }    
}
