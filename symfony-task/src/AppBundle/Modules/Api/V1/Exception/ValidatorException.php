<?php

namespace AppBundle\Modules\Api\V1\Exception;

use Doctrine\DBAL\Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidatorException extends BadRequestHttpException
{
    private ConstraintViolationListInterface $violations;

    public function __construct(
        ConstraintViolationListInterface $violations,
        $message = "Bad validation", $code = 0,
        ?Exception $previous = null
    )
    {
        parent::__construct($message, $previous, $code);
        $this->violations = $violations;
    }

    public function getDetail(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}