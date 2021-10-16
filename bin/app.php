#!/usr/bin/env php
<?php

use Framework\Console\Input;
use App\Console\Command\CacheClearCommand;
use Framework\Console\Output;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';

$commands = [
    $container->get(CacheClearCommand::class),
];

$input = new Input($argv);
$output = new Output();
$name = $input->getArgument(0);

if (! empty($name)) {
    foreach ($commands as $command) {
        if ($command->getName() === $name) {
            /** @var \Framework\Console\AbstractCommand $command */
            $command->execute($input, $output);
            exit;
        }
    }

    throw new \InvalidArgumentException('Given undefined command ' . $name);
}

$output->writeln('<comment>Available commands</comment>');
$output->writeln('');

foreach ($commands as $command) {
    $output->writeln('<info>' . $command->getName() . '</info>' . "\t" . $command->getDescription());
}

$output->writeln('');
