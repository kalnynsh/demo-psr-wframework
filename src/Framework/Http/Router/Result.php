<?php

namespace Framework\Http\Router;

class Result
{
    private string $name;
    private $handler;
    private array $attributes;

    public function __construct(string $name, $handler, array $attributes)
    {
        $this->name = $name;
        $this->handler = $handler;
        $this->attributes = $attributes;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of handler
     */ 
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Get the value of attributes
     */ 
    public function getAttributes()
    {
        return $this->attributes;
    }
}
