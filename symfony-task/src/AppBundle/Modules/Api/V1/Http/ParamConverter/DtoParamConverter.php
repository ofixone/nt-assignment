<?php

namespace AppBundle\Modules\Api\V1\Http\ParamConverter;

use AppBundle\Modules\Api\V1\Exception\ValidatorException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class DtoParamConverter implements ParamConverterInterface
{
    public const TYPE = 'dto_param_converter';

    public const SOURCE_BODY  = 'body';
    public const SOURCE_QUERY = 'query';

    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private DenormalizerInterface $denormalizer;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        DenormalizerInterface $denormalizer
    )
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @throws Throwable
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $options = $configuration->getOptions();

        $source = $options['source'] ?? self::SOURCE_BODY;

        try {
            $class = $configuration->getClass();
            $dto = new $class();

            $params = [
                AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => true,
                AbstractNormalizer::OBJECT_TO_POPULATE => $dto,
                AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true
            ];

            if (!empty($options['groups'])) {
                $params[AbstractNormalizer::GROUPS] = $options['groups'];
            }

            switch ($source) {
                case self::SOURCE_BODY:
                    $dto = $this->serializer->deserialize(
                        $request->getContent(),
                        $configuration->getClass(),
                        'json',
                        $params
                    );
                    break;
                case self::SOURCE_QUERY:
                    $dto = $this->denormalizer->denormalize(
                        $request->query->all(),
                        $configuration->getClass(),
                        'array',
                        $params
                    );
                    break;
                default:
                    throw new \DomainException('Unrecognized converter type');
            }


        } catch (Throwable $e) {
            return $this->throwException($e, $configuration);
        }

        $request->attributes->set($configuration->getName(), $dto);

        $violations = $this->validator->validate(
            $dto,
            null,
            !empty($options['groups']) ? $options['groups'] : null
        );

        if (count($violations) > 0) {
            return $this->throwException(
                new ValidatorException($violations),
                $configuration
            );
        }

        return true;
    }

    /**
     * @throws Throwable
     */
    private function throwException(
        Throwable $exception, ParamConverter $configuration
    ): bool
    {
        if ($configuration->isOptional()) {
            return false;
        }

        throw $exception;
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() !== null &&
            $configuration->getConverter() === self::TYPE;
    }
}