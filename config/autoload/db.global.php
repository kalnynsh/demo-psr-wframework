<?php

return [
    'dependencies' => [

        'factories' => [
            PDO::class => Infrastructure\App\DB\PDOfactory::class,
        ],
    ],

    'pdo' => [
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ],
];
