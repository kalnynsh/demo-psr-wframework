<?php

namespace Infrastructure\App\Repository\Post;

use App\Entity\Post\Post;
use Psr\Container\ContainerInterface;
use App\Repository\Post\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

class PostRepositoryFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);

        /** @var Doctrine\ORM\EntityRepository $repository */
        $repository = $em->getRepository(Post::class);

        return new PostRepository($repository);
    }
}
