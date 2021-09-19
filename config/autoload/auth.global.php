<?php

use Interop\Container\ContainerInterface;
use App\Http\Middleware\BasicAuthMiddleware;
use Laminas\Diactoros\Response;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {

                return new BasicAuthMiddleware(
                    $container->get('config')['auth']['users'],
                    new Response()
                );
            },
        ]
    ],

    'auth' => [
        'users' => [],
    ]
];
