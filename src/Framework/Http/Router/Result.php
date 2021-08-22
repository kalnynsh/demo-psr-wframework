<?php

namespace Framework\Http\Router;

use Psr\Http\Server\RequestHandlerInterface;

class Result
{
    private string $name;

    /** @var class-string<RequestHandlerInterface>|mixed */
    private mixed $handler;
    private array $attributes;

    public function __construct(
        string $name, 
        string $handler, 
        array $attributes
    ) {
        $this->name = $name;

        /** @var class-string<RequestHandlerInterface>|mixed $handler */
        $this->handler = $handler;
        $this->attributes = $attributes;
    }

    /**
     * Get the value of name
     * 
     * @return string
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of handler
     * 
     * @return class-string<RequestHandlerInterface>|mixed
     */ 
    public function getHandler(): mixed
    {
        return $this->handler;
    }

    /**
     * Get the value of attributes
     * 
     * @return array<array-key, mixed>
     */ 
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
