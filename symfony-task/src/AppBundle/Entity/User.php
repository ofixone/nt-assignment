<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private ?string $email = null;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    private ?string $password = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        return null;
    }
}
