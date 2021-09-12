<?php

namespace App\Repository\Post;

use App\Domain\Post\PostEntity;
use App\DataGenerator\Post\PostGenerator;

class PostRepository
{
    /** @var PostEntity[] $posts */
    private array $posts;
    private PostGenerator $generator;

    public function __construct(PostGenerator $generator)
    {
        $this->generator = $generator;
        $this->posts = $this->generator->getPosts();
    }

    /**
     *
     * @return PostEntity[]
     */
    public function getAll(): array
    {
        return \array_reverse($this->posts);
    }

    public function getPostById(int $id): ?PostEntity
    {
        foreach ($this->posts as $post) {
            if ($post->id === $id) {
                return $post;
            }
        }

        return null;
    }

    public function getAmount(): int
    {
        return \count($this->posts);
    }
}
