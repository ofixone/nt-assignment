<?php

namespace App\Http\Responses;

class StatusResponse
{
    private $status;

    public function __construct(bool $status = true)
    {
        $this->status = $status;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }
}