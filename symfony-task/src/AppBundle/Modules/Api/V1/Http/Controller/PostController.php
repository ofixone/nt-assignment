<?php

namespace AppBundle\Modules\Api\V1\Http\Controller;

use AppBundle\Modules\Post\UseCases;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Modules\Api\V1\Http\ParamConverter\DtoParamConverter;

class PostController extends Controller
{
    /**
     * @Route("/v1/api/posts", name="api_v1_posts_index", methods={"GET"})
     * @ParamConverter("dto",
     *     class=UseCases\Index\Dto::class,
     *     converter=DtoParamConverter::TYPE,
     *     options={"source": DtoParamConverter::SOURCE_QUERY}
     * )
     */
    public function indexAction(
        UseCases\Index\Command $command, UseCases\Index\Dto $dto
    ): JsonResponse
    {
        return $this->json($command->handle($dto));
    }
}