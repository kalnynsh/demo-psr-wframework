<?php

defined ('DIR_PREFFIX') || define(
        'DIR_PREFFIX',
        __DIR__
        . DIRECTORY_SEPARATOR
        . 'autoload'
        . DIRECTORY_SEPARATOR
);

$configs = array_map (
    function ($file) {
        return require $file;
    },
    glob (DIR_PREFFIX . '{{,*.}global,{,*.}local}.php', GLOB_BRACE)
);

return \array_merge_recursive (...$configs);
