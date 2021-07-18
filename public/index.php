<?php

use App\Http\Action;
use App\Http\Middleware;
use Aura\Router\RouterContainer;
use Framework\Http\ActionResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Psr\Http\Message\ServerRequestInterface;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();

### Initialization
$usersParams = [
    'users' => [
        'admin' => 'adminPassword',
    ]
];

$auraRouterContainer = new RouterContainer();
$routes = $auraRouterContainer->getMap();

$routes->get('home', '/', Action\Home\IndexAction::class);

$routes->get('about', '/about', Action\Home\AboutAction::class);

$routes->get(
    'cabinet', 
    '/cabinet',
    
    function (ServerRequestInterface $request) use ($usersParams) {

        $profiler = new Middleware\ProfilerMiddleware();
        $auth = new Middleware\BasicAuthMiddleware($usersParams['users']);
        $cabinet = new Action\Home\CabinetAction();

        return $profiler($request, function (ServerRequestInterface $request) use ($auth, $cabinet) {
            return $auth($request, function(ServerRequestInterface $request) use ($cabinet) {
                                            return $cabinet($request);
                                    });
        });
        
    }
);

$routes->get('blog', '/blog', Action\Blog\IndexAction::class);

$routes->get(
    'blog_show',
    '/blog/{id}',
    Action\Blog\ShowAction::class    
)->tokens(['id' => '\d+']);

$router = new AuraRouterAdapter($auraRouterContainer);
$resolver = new ActionResolver();

# Running
$request = ServerRequestFactory::fromGlobals();

try {
    $result = $router->match($request);

    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }


    $handler = $result->getHandler();

    /** @var callable $action */
    $action = $resolver->resolve($handler);
    $response = $action($request);
} catch (RequestNotMatchedException $exc) {
    $response = new HtmlResponse('Undefined page', 404);
}

## Postprosessing

$response = $response->withHeader('X-Developer', 'Denis');

## Sending

$emmiter = new SapiEmitter();
$emmiter->emit($response);
