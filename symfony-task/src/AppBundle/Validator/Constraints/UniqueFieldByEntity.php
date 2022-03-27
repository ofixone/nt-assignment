<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 * @package App\Validator\Constraints
 */
class UniqueFieldByEntity extends Constraint
{
    public string $message = 'This value is already used.';
    public string $entityClass;
    public string $field;
    public ?string $validateFoundedEntity = null;

    public function getRequiredOptions(): array
    {
        return ['entityClass', 'field'];
    }

    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return get_class($this) . 'Validator';
    }
}