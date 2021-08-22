<?php

use Interop\Container\ContainerInterface;
use App\Http\Middleware\BasicAuthMiddleware;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {

                return new BasicAuthMiddleware(
                    $container->get('config')['auth']['users']
                );
            },
        ]
    ],

    'auth' => [
        'users' => [],
    ]
];
