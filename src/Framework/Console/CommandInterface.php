<?php

namespace Framework\Console;

use Framework\Console\Input;
use Framework\Console\Output;

interface CommandInterface
{
    public function execute(Input $input, Output $output): void;
}
