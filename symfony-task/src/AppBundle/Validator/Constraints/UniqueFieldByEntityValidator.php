<?php

namespace AppBundle\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueFieldByEntityValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @inheritDoc
     * @param UniqueFieldByEntity $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (
            $constraint->validateFoundedEntity && !method_exists(
                $this->context->getObject(),
                $constraint->validateFoundedEntity
            )
        ) {
            throw new InvalidArgumentException(
                get_class($this->context->getObject())
                . ' must have method '
                . $constraint->validateFoundedEntity
            );
        }

        $entityRepository = $this->em->getRepository($constraint->entityClass);

        $searchResult = $entityRepository->findOneBy([
            $constraint->field => $value
        ]);

        $contextObject = $this->context->getObject();

        if (
            $searchResult
            && (!$constraint->validateFoundedEntity ||
                $contextObject->{$constraint->validateFoundedEntity}(
                    $searchResult
                ))
        ) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}