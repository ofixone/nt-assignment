<?php

namespace AppBundle\Modules\Post\UseCases\Index;

class Dto
{
    private ?int $page = 1;
    private ?int $perPage = 25;

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page): void
    {
        $this->page = $page;
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function setPerPage(?int $perPage): void
    {
        $this->perPage = $perPage;
    }
}