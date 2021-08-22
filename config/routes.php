<?php

use App\Http\Action;

/** @var Framework\Http\Application $app */

$app->addGetRoute('home', '/', Action\Home\IndexAction::class);

$app->addGetRoute('about', '/about', Action\Home\AboutAction::class);

$app->addGetRoute(
    'cabinet', 
    '/cabinet',      
    Action\Home\CabinetAction::class 
);

$app->addGetRoute('blog', '/blog', Action\Blog\IndexAction::class);

$app->addGetRoute(
    'blog_show',
    '/blog/{id}',
    Action\Blog\ShowAction::class,
    [
        'tokens' => ['id' => '\\d+',],
    ]   
);
