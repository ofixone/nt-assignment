<?php

namespace AppBundle\Modules\Auth\UseCases\Registration;

use AppBundle\Validator\Constraints\UniqueFieldByEntity;
use Symfony\Component\Validator\Constraints as Assert;

class Dto
{
    /**
     * @Assert\NotBlank
     */
    private ?string $name = null;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @UniqueFieldByEntity(
     *     entityClass="AppBundle\Entity\User",
     *     field="email"
     * )
     */
    private ?string $email = null;

    /**
     * @Assert\NotBlank
     */
    private ?string $password = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }
}