<?php

namespace App\DAO\Post;

use App\Domain\Post\PostEntity;

class PostDAO
{
    private \PDO $pdo;
    private string $tableName = 'posts';

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
    *
    * @return PostEntity[]
    */
    public function getAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT * FROM '
            . $this->tableName
            . ' ORDER BY id DESC'
        );

        return \array_map([$this, 'postMap'], $stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function find(int $id): ?PostEntity
    {

        $stmt = $this->pdo->prepare('SELECT * FROM posts WHERE id = ?');
        $stmt->execute([$id]);

        return ($row = $stmt->fetch()) ? $this->postMap($row) : null;
    }

    public function getAmount(): int
    {
        $stmt = $this->pdo->query(
            'SELECT COUNT(*) FROM'
            . $this->tableName
            . ' WHERE 1 = 1'
        );

        return ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) ? (int) $row['id'] : 0;
    }

    private function postMap(array $row): PostEntity
    {
        $post = new PostEntity();

        $post->id = (int) $row['id'];
        $post->date = new \DateTimeImmutable($row['date']);
        $post->title = $row['title'];

        $post->content = $row['content'];

        return $post;
    }
}
