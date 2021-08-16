<?php

use App\Http\Middleware;

use function Laminas\Stratigility\path;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\Stratigility\Middleware\NotFoundHandler;

/** @var Framework\Container\Container $serviceLocator */
/** @var Framework\Http\Application $app */

// Own ErrorHandlerMiddleware
// $app->pipe(new Middleware\ErrorHandlerMiddleware($isDebugMode));

$app->pipe(
    $serviceLocator->get(Middleware\ProfilerMiddleware::class)
);

$app->pipe(
    $serviceLocator->get(Middleware\CredentialsMiddleware::class)
);

$app->pipe(
    new Framework\Http\Middleware\RouteMiddleware(
    $app->getRouter()
    )
);

$app->pipe(path(
    '/cabinet', 
    $serviceLocator->get(Middleware\BasicAuthMiddleware::class)
));

$app->pipe(
    $serviceLocator->get(Framework\Http\Middleware\DispatcherMiddleware::class)
);

$app->pipe(
    $serviceLocator->get(NotFoundHandler::class)
);

// Laminas ErrorHandler
$app->pipe(
    $serviceLocator->get(ErrorHandler::class)
);
