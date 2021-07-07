<?php

use Framework\Http\Request;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();
header('X-Developer: Denis');

### Initialization
$request = new Request($_GET, $_POST);

### Action
$name = !empty($param = $request->getQueryParams()['name']) ? $param : 'Guest';

echo 'Hello, ' . $name . '!';
