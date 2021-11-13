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

    public function countAll(): int
    {
        return (int) $this
                ->pdo
                ->query(
                    'SELECT COUNT(id) FROM posts'
                )
                ->fetchColumn()
        ;
    }

    /**
     * @param int $offset
     * @param int $limit
    *
    * @return PostEntity[]
    */
    public function all(int $offset, int $limit): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM '
            . $this->tableName
            . ' ORDER BY id DESC LIMIT ? OFFSET ?'
        );

        $stmt->execute([$limit, $offset]);

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
            'SELECT COUNT(id) FROM '
            . $this->tableName
            . ' WHERE 1 = 1'
        );

        return $stmt->fetchColumn(0) === false ? 0 : $stmt->fetchColumn(0);
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
