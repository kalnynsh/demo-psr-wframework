<?php

defined ('DIR_PREFFIX') || define(
        'DIR_PREFFIX',
        __DIR__
        . DIRECTORY_SEPARATOR
        . 'autoload'
        . DIRECTORY_SEPARATOR
);

return \array_merge_recursive (
    require DIR_PREFFIX . 'app.global.php',
    require DIR_PREFFIX . 'auth.global.php',
    require DIR_PREFFIX . 'auth.local.php',
);
