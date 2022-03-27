<?php

namespace AppBundle\Modules\Post\DataFixtures;

use AppBundle\Entity\Post;
use AppBundle\Modules\Post\UseCases\Add\Command;
use AppBundle\Modules\Post\UseCases\Add\Dto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class PostFixture extends Fixture
{
    private Generator $faker;
    private Command $command;
    private array $textDummies;
    private array $titleDummies;

    public function __construct(Command $command)
    {
        $this->faker = Factory::create();
        $this->command = $command;

        $this->generateTextDummies();
        $this->generateTitleDummies();
    }


    public function load(ObjectManager $manager)
    {
        $manager->getConnection()->getConfiguration()->setSqlLogger(null);

        /** @noinspection PhpUnhandledExceptionInspection */
        $totalCount = random_int(95000, 105000);
        for ($i = 1; $i <= $totalCount; $i++) {
            $dto = new Dto();
            $dto->setTitle($this->titleDummies[array_rand($this->titleDummies)])
                ->setBody($this->textDummies[array_rand($this->textDummies)]);

            $this->command->handle($dto);

            if ($i % 500 === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        $manager->flush();
        $manager->clear();
    }

    private function generateTextDummies(): void
    {
        for ($i = 1; $i <= 300; $i++) {
            $this->textDummies[] = $this->faker->realText;
        }
    }

    private function generateTitleDummies(): void
    {
        for ($i = 1; $i <= 300; $i++) {
            $this->titleDummies[] = $this->faker->sentence;
        }
    }
}