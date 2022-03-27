<?php

namespace AppBundle\Modules\Auth\UseCases\Registration;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Command
{
    private EntityManagerInterface $em;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(
        EntityManagerInterface $em, UserPasswordEncoderInterface $encoder
    )
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    public function handle(Dto $dto): void
    {
        $newUser = new User();
        $newUser->setName($dto->getName())
            ->setEmail($dto->getEmail())
            ->setPassword(
                $this->encoder->encodePassword($newUser, $dto->getPassword())
            );

        $this->em->persist($newUser);
        $this->em->flush();
    }
}