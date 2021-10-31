<?php

use App\Http\Action;

/** @var Framework\Http\Application $app */

$app->get('home', '/', Action\Home\IndexAction::class);

$app->get('about', '/about', Action\Home\AboutAction::class);

$app->get(
    'cabinet',
    '/cabinet',
    Action\Home\CabinetAction::class
);

$app->get('blog', '/blog', Action\Blog\IndexAction::class);


$app->get(
    'blog_page',
    '/blog/page/{page}',
    Action\Blog\IndexAction::class,
    [
        'tokens' => ['page' => '\d+',],
    ]
);

$app->get(
    'blog_show',
    '/blog/{id}',
    Action\Blog\ShowAction::class,
    [
        'tokens' => ['id' => '\d+',],
    ]
);
