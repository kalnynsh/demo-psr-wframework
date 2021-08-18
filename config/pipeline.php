<?php

use App\Http\Middleware;

use function Laminas\Stratigility\path;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\Stratigility\Middleware\NotFoundHandler;

/** @var Framework\Container\Container $serviceLocator */
/** @var Framework\Http\Application $app */

// Own ErrorHandlerMiddleware
// $app->pipe(new Middleware\ErrorHandlerMiddleware($isDebugMode));

$app->pipe(Middleware\ProfilerMiddleware::class);

$app->pipe(Middleware\CredentialsMiddleware::class);

$app->pipe(Framework\Http\Middleware\RouteMiddleware::class);

$app->pipe(path(
    '/cabinet', 
    $serviceLocator->get(Middleware\BasicAuthMiddleware::class)
));

$app->pipe(Framework\Http\Middleware\DispatcherMiddleware::class);

$app->pipe(NotFoundHandler::class);

// Laminas ErrorHandler
$app->pipe(ErrorHandler::class);
