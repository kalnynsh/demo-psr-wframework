<?php

namespace Infrastructure\App\DB;

use Psr\Container\ContainerInterface;

class PDOfactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        /** @var array $pdo */
        $pdo = $container->get('config')['pdo'];

        return new \PDO(
            $pdo['dsn'],
            $pdo['username'],
            $pdo['password'],
            $pdo['options']
        );
    }
}
