<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;
use AppBundle\Modules\Post\Contracts\PostRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class PostRepository extends ServiceEntityRepository
    implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getTargetForPagination(): QueryBuilder
    {
        return $this->createQueryBuilder('Post')
            ->addOrderBy('Post.id', 'DESC');
    }
}
