<?php

namespace App\Domain\Post;

class PostEntity
{
    public int $id;
    public \DateTimeImmutable $date;
    public string $title;
    public string $content;
}
