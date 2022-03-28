<?php

namespace AppBundle\Modules\Post\UseCases\Index;

use AppBundle\Entity\Post;
use AppBundle\Modules\Post\Contracts\PostRepositoryInterface;
use AppBundle\Repository\PostRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class Command
{
    private PaginatorInterface $paginator;
    private PostRepositoryInterface $repository;

    public function __construct(
        PaginatorInterface $paginator, PostRepository $repository
    )
    {
        $this->paginator = $paginator;
        $this->repository = $repository;
    }

    /**
     * @param mixed $paginationTarget
     * @see PaginatorInterface::paginate()
     *
     * @param int $page
     * @param int $perPage
     *
     * @return PaginationInterface
     */
    private function getPagination(
        $paginationTarget, int $page, int $perPage
    ): PaginationInterface
    {
        return $this->paginator->paginate($paginationTarget, $page, $perPage, [
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
            $this->repository->getTargetForPagination(),
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