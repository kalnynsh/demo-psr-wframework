<?php

namespace App\DAO\Post;

use App\Domain\Post\PostEntity;

class PostArrayDAO
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
    * @return array
    */
    public function all(int $offset, int $limit): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT p.* '
            . ',(SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) comments_count'
            . ' FROM '
            . $this->tableName
            . ' p'
            . ' ORDER BY p.create_date DESC'
            . ' LIMIT :limit OFFSET :offset'
        );

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();

        return \array_map([$this, 'hydratePostList'], $stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function find(int $id): ?array
    {

        $stmt = $this->pdo->prepare('SELECT * FROM posts WHERE id = :id');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        if (! $post = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return null;
        }

        $stmt = $this
            ->pdo
            ->prepare('SELECT c.* FROM comments c WHERE c.post_id = :post_id ORDER BY c.id ASC')
        ;

        $stmt->bindValue(':post_id', (int) $post['id'], \PDO::PARAM_INT);
        $stmt->execute();

        $comments = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->hydratePostDetail($post, $comments);
    }

    private function hydratePostList(array $row): array
    {
        return [
            'id' => (int) $row['id'],
            'date' => new \DateTimeImmutable($row['create_date']),
            'title' => $row['title'],
            'preview' => $row['content_short'],
            'commentsCount' => $row['comments_count'],
        ];
    }

    private function hydratePostDetail(array $row, array $comments): array
    {
        return [
            'id' => (int) $row['id'],
            'date' => new \DateTimeImmutable($row['create_date']),
            'title' => $row['title'],
            'content' => $row['content_full'],
            'meta' => [
                'title' => $row['meta_title'],
                'description' => $row['meta_description'],
            ],
            'commentsCount' => empty($comments) ? 0 : \count($comments),
            'comments' => \array_map(
                [$this, 'hydrateComment'],
                $comments
            ),
        ];
    }

    private function hydrateComment(array $row): array
    {
        return [
            'id' => $row['id'],
            'date' => new \DateTimeImmutable($row['date']),
            'author' => $row['author'],
            'text' => $row['text'],
        ];
    }
}
