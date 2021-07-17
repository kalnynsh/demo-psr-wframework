<?php

namespace Framework\Http\Router\Route;

use in_array;
use preg_match;

use array_filter;
use array_key_exists;
use preg_replace_callback;
use Framework\Http\Router\Result;

use Framework\Http\Router\Route\Route;
use Psr\Http\Message\ServerRequestInterface;

class RegexpRoute implements Route
{
    private string $name;
    private string $pattern;
    private $handler;
    private array $methods;
    private array $tokens;

    public function __construct(
        string $RouteName,
        string $pattern,
        $handler,
        array $methods,
        array $tokens = []
    ) {
        $this->name = $RouteName;
        $this->pattern = $pattern;
        $this->handler = $handler;
        $this->methods = $methods;
        $this->tokens = $tokens;
    }

    public function match(ServerRequestInterface $request): ?Result
    {

        if ($this->methods && ! in_array($request->getMethod(), $this->methods, true)) {
            return null;
        }

        $pattern = preg_replace_callback(
            '~\{([^\}]+)\}~',
            function ($matches) {
                $argument = $matches[1];
                $replace = $this->tokens[$argument] ?? '[^\}]+';

                return '(?P<' . $argument . '>' . $replace . ')';
            },
            $this->pattern
        );

        $path = $request->getUri()->getPath();

        if (! preg_match('~^' . $pattern . '$~i', $path, $matches)) {

            return null;
        }

        return new Result(
            $this->name,
            $this->handler,
            array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY)
        );
    }

    public function generate($name, array $params = []): ?string
    {
        $arguments = array_filter($params);

        if ($name !== $this->name) {
            return null;
        }

        $url = preg_replace_callback(
            '~\{([^\}]+)\}~',
            function ($matches) use (&$arguments) {

                $argument = $matches[1];

                if (! array_key_exists($argument, $arguments)) {
                    throw new \InvalidArgumentException('Missing parameter "' . $argument . '"');
                }

                return $arguments[$argument];
            },
            $this->pattern
        );

        return $url;
    }
}
