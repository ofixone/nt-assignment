<?php

namespace AppBundle\Modules\Post\UseCases\Index;

use AppBundle\Entity\Post;
use AppBundle\Repository\PostRepository;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class Command
{
    private PaginatorInterface $paginator;
    private PostRepository $repository;

    public function __construct(
        PaginatorInterface $paginator, PostRepository $repository
    )
    {
        $this->paginator = $paginator;
        $this->repository = $repository;
    }

    private function getPagination(
        QueryBuilder $queryBuilder, int $page, int $perPage
    ): PaginationInterface
    {
        return $this->paginator->paginate($queryBuilder, $page, $perPage, [
            'distinct' => true
        ]);
    }

    /**
     * @param Dto $dto
     *
     * @return array{data: array<Post>, pagination: array}
     */
    public function handle(Dto $dto): array
    {
        $pagination = $this->getPagination(
            $this->repository->createQueryBuilder('Post')
                ->addOrderBy('Post.id', 'DESC'),
            $dto->getPage(),
            $dto->getPerPage()
        );

        return [
            'data' => $pagination->getItems(),
            'pagination' => array_filter(
                $pagination->getPaginationData(),
                static function ($key) {
                    return in_array($key, [
                        'last',
                        'current',
                        'numItemsPerPage',
                        'first',
                        'pageCount',
                        'totalCount',
                        'pageRange',
                        'startPage',
                        'endPage'
                    ]);
                },
                ARRAY_FILTER_USE_KEY
            )
        ];
    }
}