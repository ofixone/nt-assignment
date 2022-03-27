<?php

namespace App\Http\Responses;

use ArrayObject;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonExceptionResponse extends JsonResponse
{
    /**
     * @param string $type
     * @param string|null $message
     * @param mixed $data
     * @param array $detail
     * @param int $status
     * @param array $headers
     * @param bool $json
     */
    public function __construct(
        string $type, ?string $message, $data = null, array $detail = [],
        int $status = 200, array $headers = [], bool $json = false
    )
    {
        parent::__construct(
            $this->format($type, $message, $detail, $data),
            $status,
            $headers,
            $json
        );
    }

    /**
     * @param string $type
     * @param string|null $message
     * @param array $developmentInformation
     *
     * @param mixed $data
     * @return array
     */
    private function format(
        string $type, ?string $message, array $developmentInformation,
        $data = null
    ): array
    {
        if ($data === null) {
            $data = new ArrayObject();
        }

        $response = [
            'type' => $type,
            'title' => $message,
            'data' => $data
        ];

        if ($developmentInformation) {
            $response['development'] = $developmentInformation;
        }

        return $response;
    }
}