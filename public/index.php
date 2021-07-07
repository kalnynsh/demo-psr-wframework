<?php

use Framework\Http\Request;

/** Go to Root dir */
chdir(dirname(__DIR__));

// require 'src/Framework/Http/Request.php';

require 'vendor/autoload.php';

session_start();

### Initialization
$request = new Request();


function getLang(
    Request $request, 
    string $default
    ) {

        if (!empty($lang = $request->getQueryParams()['lang'])) {
            return $lang;
        }

        if (!empty($lang = $request->getCookies()['lang'])) {
            return $lang;
        }

        if (!empty($lang = $request->getSession()['lang'])) {
            return $lang;
        }

        if (!empty($serverAccpectLang = $request->getServer()['HTTP_ACCEPT_LANGUAGE'])) {
            return substr($serverAccpectLang, 0, 2);
        }

        return $default;
}


$name = !empty($param = $request->getQueryParams()['name']) ? $param : 'Guest';
$lang = getLang($request, 'en');

header('X-developer: Denis');
echo 'Hello, ' . $name . '! Are you speaking ' . $lang . ' ?';

