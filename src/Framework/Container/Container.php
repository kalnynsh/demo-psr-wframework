<?php

namespace Framework\Container;

use Psr\Container\ContainerInterface;
use Framework\Container\Exception\ServiceNotFoundException;

class Container implements ContainerInterface
{
    private array $definitions;
    private array $results = [];

    public function __construct(array $definitions = [])
    {
        $this->definitions = $definitions;
    }

    /** @param class-string|string $id 
     * 
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
    */
    public function get(string $id)
    {
        if (\array_key_exists($id, $this->results)) {
            return $this->results[$id];
        }

        if (! \array_key_exists($id, $this->definitions)) {

            if (\class_exists($id)) {

                $this->addObjectWithArgs($id);

                return $this->results[$id];
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

    /** 
     * @param class-string|string $id 
     * @return bool
    */
    public function has(string $id)
    {
        return array_key_exists($id, $this->definitions)
            || class_exists($id);
    }

    public function set($id, $value): void
    {
        $this->definitions[$id] = $value;
    }

    private function addObjectWithArgs($id): void
    {
        $reflection = new \ReflectionClass($id);
        $arguments = [];

        /** @var \ReflectionMethod|null $constructor */
        if (($constructor = $reflection->getConstructor()) !== null) {

            /** @var \ReflectionParameter[] $constructor->getParameters() */
            /** @var \ReflectionParameter $parameter */
            foreach ($constructor->getParameters() as $parameter) {
                /** @var \ReflectionNamedType|null $parameterType */
                $parameterType = $parameter->getType();
                
                if (! $parameterType ) {
                    continue;
                }

                $parameterTypeName = $parameterType->getName();

                if ($this->isInstatiatable($parameterTypeName)) {
                    /** @var class-string $className */
                    $className = $parameterTypeName;
                    $arguments[] = $this->get($className);

                } elseif (mb_strtolower($parameterTypeName) === 'array') {

                    $arguments[] = [];

                } elseif (! $parameter->isDefaultValueAvailable()) {
                    throw new ServiceNotFoundException(
                        'Unable resolve parameter "' 
                        . $parameter->getType()->getName()
                        . '" of ' 
                        . $id
                        . ' service.' 
                    );
                } else { 
                    $arguments[] = $parameter->getDefaultValue();
                }                            
            }  
        }

        $this->results[$id] = $reflection->newInstanceArgs($arguments);
    }

    /** @param string $typeName */
    private function isInstatiatable($typeName): bool
    {
        return mb_strtolower($typeName) != 'closure' 
                && !is_callable($typeName) ;
    }
}
