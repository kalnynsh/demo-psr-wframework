<?php

namespace Infrastructure\App\Console\Command;

use App\Console\Command\CacheClearCommand;
use App\Service\FileService\FileManager;
use Psr\Container\ContainerInterface;

class CacheClearCommandFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new CacheClearCommand(
            $container->get('config')['console']['cachePaths'],
            $container->get(FileManager::class)
        );
    }
}
