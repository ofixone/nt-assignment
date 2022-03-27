<?php

namespace AppBundle\Normalizer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Throwable;

class ExceptionNormalizer implements ContextAwareNormalizerInterface
{
   public function supportsNormalization(
       $data, $format = null, array $context = []
   ): bool
   {
       return $data instanceof Throwable;
   }

    public function normalize($object, $format = null, array $context = []): array
    {
        return $_ENV['APP_ENV'] !== 'prod' ? [
            'class' => get_class($object),
            'message' => $object->getMessage(),
            'file' => $object->getFile(),
            'line' => $object->getLine(),
            'trace' => $object->getTrace()
        ] : [];
    }
}