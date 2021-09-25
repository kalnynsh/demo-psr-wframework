<?php

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

defined('DIR_PREFFIX') || define(
    'DIR_PREFFIX',
    __DIR__
    . DIRECTORY_SEPARATOR
    . 'autoload'
    . DIRECTORY_SEPARATOR
);

$aggregator = new ConfigAggregator([
    new PhpFileProvider(DIR_PREFFIX . '{{,*.}global,{,*.}local}.php'),
]);

return $aggregator->getMergedConfig();
