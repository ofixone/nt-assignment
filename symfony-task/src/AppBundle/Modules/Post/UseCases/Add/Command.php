<?php

namespace AppBundle\Modules\Post\UseCases\Add;

use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Command
{
    private EntityManagerInterface $em;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    public function handle(Dto $dto): void
    {
        $newUser = new Post();
        $newUser->setTitle($dto->getTitle())
            ->setBody($dto->getBody());

        $this->em->persist($newUser);
    }
}