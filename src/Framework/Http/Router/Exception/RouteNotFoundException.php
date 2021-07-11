<?php

namespace Framework\Http\Router\Exception;

class RouteNotFoundException extends \LogicException
{
    private string $name;
    private array $params;

    public function __construct(string $name, array $params)
    {
        parent::__construct('Route "' . $name . '" nor found.');
        $this->name = $name;
        $this->params = $params;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of params
     */ 
    public function getParams()
    {
        return $this->params;
    }
}
