<?php

use App\Http\Middleware;

// use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;

/** @var Framework\Http\Application $app */

$app->pipe(Middleware\ErrorHandler\ErrorHandlerMiddleware::class);

$app->pipe(Middleware\ProfilerMiddleware::class);

$app->pipe(Middleware\CredentialsMiddleware::class);

$app->pipe(Framework\Http\Middleware\RouteMiddleware::class);

$app->pipe(PathMiddlewareDecorator::class);

$app->pipe(Framework\Http\Middleware\DispatcherMiddleware::class);

$app->pipe(NotFoundHandler::class);
