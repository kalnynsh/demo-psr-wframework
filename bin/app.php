#!/usr/bin/env php
<?php

use Framework\Console\Input;
use Framework\Console\Output;
use Symfony\Component\Console\Application;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';

$cli = new Application('Console application');
$cli->run();
