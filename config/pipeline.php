<?php

use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;

/** @var Framework\Http\Application $app */

$app->pipe(\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware::class);

$app->pipe(\Infrastructure\Framework\Http\Middleware\ResponseLoggerMiddleware::class);

$app->pipe(\App\Http\Middleware\ProfilerMiddleware::class);

$app->pipe(\App\Http\Middleware\CredentialsMiddleware::class);

$app->pipe(\Framework\Http\Middleware\RouteMiddleware::class);

$app->pipe(PathMiddlewareDecorator::class);

$app->pipe(\Framework\Http\Middleware\DispatcherMiddleware::class);

$app->pipe(NotFoundHandler::class);
