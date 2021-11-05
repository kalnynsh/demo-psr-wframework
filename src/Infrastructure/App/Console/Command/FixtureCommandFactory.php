<?php

namespace Infrastructure\App\Console\Command;

use Psr\Container\ContainerInterface;
use App\Console\Command\FixtureCommand;
use Doctrine\ORM\EntityManagerInterface;

class FixtureCommandFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new FixtureCommand(
            $container->get(EntityManagerInterface::class),
            'db/fixtures'
        );
    }
}
