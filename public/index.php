<?php

use Framework\Http\RequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();
header('X-Developer: Denis');

### Initialization
$request = RequestFactory::fromGlobals();

### Action
$queryParams = $request->getQueryParams();
$name = $queryParams['name'] ?? 'Guest';

echo 'Hello, ' . $name . '!';
