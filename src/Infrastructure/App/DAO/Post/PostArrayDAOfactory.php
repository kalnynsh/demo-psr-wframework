<?php

namespace Infrastructure\App\DAO\Post;

use App\DAO\Post\PostArrayDAO;
use Psr\Container\ContainerInterface;

class PostArrayDAOfactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        /** @var \PDO $pdo */
        $pdo = $container->get(\PDO::class);

        return new PostArrayDAO($pdo);
    }
}
