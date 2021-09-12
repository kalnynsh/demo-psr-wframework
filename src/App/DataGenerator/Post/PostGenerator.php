<?php

namespace App\DataGenerator\Post;

use App\Domain\Post\PostEntity;

class PostGenerator
{
    public function getPosts(): array
    {
        return [
            new PostEntity(1, new \DateTimeImmutable(), 'The first post', 'Content of 1-st post'),
            new PostEntity(2, new \DateTimeImmutable(), 'The second post', 'Content of 2-nd post'),
            new PostEntity(3, new \DateTimeImmutable(), 'The third post', 'Content of 3-d post'),
            new PostEntity(4, new \DateTimeImmutable(), 'The fourth post', 'Content of 4-th post'),
            new PostEntity(5, new \DateTimeImmutable(), 'The fifth post', 'Content of 5-th post'),
            new PostEntity(6, new \DateTimeImmutable(), 'The sixth post', 'Content of 6-th post'),
        ];
    }
}
