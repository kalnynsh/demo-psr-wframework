<?php

use Framework\Http\RequestFactory;
use Framework\Http\Response;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();

### Initialization
$request = RequestFactory::fromGlobals();

### Action
$queryParams = $request->getQueryParams();
$name = $queryParams['name'] ?? 'Guest';
$body = 'Hello, ' . $name . '!';

$response = (new Response())
    ->withBody($name)
    ->withHeader('X-Developer', 'Denis');

header(
    'HTTP/1.1 '
    . $response->getStatusCode() 
    . ' ' 
    . $response->getReasonPhrase()
);

foreach ($response->getHeaders() as $name => $value) {
    header($name . ': ' . $value);
}

echo $response->getBody();
