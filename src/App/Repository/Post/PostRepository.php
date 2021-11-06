<?php

namespace App\Repository\Post;

use App\Entity\Post\Post;
use Doctrine\ORM\EntityRepository;

class PostRepository
{
    private EntityRepository $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Query all posts with offset and limit
     *
     * @param integer $offset
     * @param integer $limit
     * @return Post[]
     */
    public function all(int $offset, int $limit): array
    {
        return $this->repository
            ->createQueryBuilder('p')
            ->select('p')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('p.createDate', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Query post by id
     *
     * @param integer $id
     * @return Post|null
     */
    public function find(int $id): ?Post
    {
        return $this->repository->find($id);
    }

    public function countAll(): int
    {
        return $this->repository
            ->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
