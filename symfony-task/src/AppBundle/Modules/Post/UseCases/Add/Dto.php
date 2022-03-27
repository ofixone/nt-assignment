<?php

namespace AppBundle\Modules\Post\UseCases\Add;

use Symfony\Component\Validator\Constraints as Assert;

class Dto
{
    /**
     * @Assert\NotBlank
     */
    private ?string $title = null;

    /**
     * @Assert\NotBlank
     */
    private ?string $body = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }
}