<?php

namespace AppBundle\Modules\Post\Contracts;

use Knp\Component\Pager\PaginatorInterface;

interface PostRepositoryInterface
{
    /**
     * @return mixed
     * @see PaginatorInterface::paginate()
     */
    public function getTargetForPagination();
}