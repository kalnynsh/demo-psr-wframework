<?php

use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;
use Infrastructure\Framework\Http\Middleware\Response\ResponseLoggerMiddleware;

/** @var Framework\Http\Application $app */

$app->pipe(\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware::class);

$app->pipe(ResponseLoggerMiddleware::class);

$app->pipe(\App\Http\Middleware\ProfilerMiddleware::class);

$app->pipe(\App\Http\Middleware\CredentialsMiddleware::class);

$app->pipe(\Framework\Http\Middleware\BodyParamsMiddleware::class);

$app->pipe(\Framework\Http\Middleware\RouteMiddleware::class);

$app->pipe(PathMiddlewareDecorator::class);

$app->pipe(\Framework\Http\Middleware\DispatcherMiddleware::class);

$app->pipe(NotFoundHandler::class);
