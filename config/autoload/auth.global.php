<?php

use App\Http\Middleware\BasicAuthMiddleware;
use Infrastructure\Framework\Http\Middleware\BasicAuth\BasicAuthMiddlewareFactory;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class =>
                BasicAuthMiddlewareFactory::class,
        ]
    ],

    'auth' => [
        'users' => [],
    ]
];
