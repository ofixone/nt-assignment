<?php

namespace AppBundle\Modules\Api\V1\Http\Controller;

use App\Http\Responses\StatusResponse;
use AppBundle\Modules\Auth\UseCases;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Modules\Api\V1\Http\ParamConverter\DtoParamConverter;

class AuthController extends Controller
{
    /**
     * @Route("/v1/api/register", name="api_v1_register", methods={"POST"})
     * @ParamConverter("dto", class=UseCases\Registration\Dto::class, converter=DtoParamConverter::TYPE)
     */
    public function registerAction(UseCases\Registration\Command $command, UseCases\Registration\Dto $dto): JsonResponse
    {
        $command->handle($dto);

        return $this->json(new StatusResponse());
    }
}