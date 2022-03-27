<?php

namespace AppBundle\EventListener;

use AppBundle\Modules\Api\V1\Exception\ValidatorException;
use App\Http\Responses\JsonExceptionResponse;
use AppBundle\Modules\Api\V1\Normalizer\ExceptionNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class ExceptionListener
{
    private $normalizer;
    private ExceptionNormalizer $exceptionNormalizer;

    public function __construct(
        NormalizerInterface $normalizer,
        ExceptionNormalizer $exceptionNormalizer
    )
    {
        $this->normalizer = $normalizer;
        $this->exceptionNormalizer = $exceptionNormalizer;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        $request = $event->getRequest();

        if (
            in_array(
                'application/json',
                $request->getAcceptableContentTypes()
            )
        ) {
            $response = $this->createApiResponse($exception);
            $event->setResponse($response);
        }
    }

    /**
     * @param Throwable $exception
     *
     * @return JsonExceptionResponse
     */
    private function createApiResponse(Throwable $exception
    ): JsonExceptionResponse
    {
        $statusCode = $exception instanceof HttpExceptionInterface ?
            $exception->getStatusCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        try {
            $detail = $this->exceptionNormalizer->normalize($exception);
            $data = [];

            if ($exception instanceof ValidatorException) {
                $data = $this->normalizer->normalize($exception->getDetail());
                unset($data['title'], $data['type']);
            }
        } catch (Throwable $exception) {
            $detail = [];
            $data = [];
        }

        return $_ENV['APP_ENV'] === 'prod' && $statusCode >= 500 ?
            new JsonExceptionResponse(
                'ServerException',
                'Unpredictable server error',
                [],
                [],
                $statusCode
            ) : new JsonExceptionResponse(
                basename(str_replace('\\', '/', get_class($exception))),
                $exception->getMessage(),
                $data,
                $detail,
                $statusCode
            );
    }
}