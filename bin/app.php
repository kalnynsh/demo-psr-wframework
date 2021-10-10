#!/usr/bin/env php
<?php

use Framework\Console\Input;
use App\Console\Command\CacheClearCommand;
use Framework\Console\Output;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';

/** @var CacheClearCommand $clearCacheCommand */
$clearCacheCommand = $container->get(CacheClearCommand::class);

$input = new Input($argv);
$output = new Output();
$clearCacheCommand->execute($input, $output);
