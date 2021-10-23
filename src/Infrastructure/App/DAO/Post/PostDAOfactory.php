<?php

namespace Infrastructure\App\DAO\Post;

use App\DAO\Post\PostDAO;
use Psr\Container\ContainerInterface;

class PostDAOfactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        /** @var \PDO $pdo */
        $pdo = $container->get(\PDO::class);

        return new PostDAO($pdo);
    }
}
