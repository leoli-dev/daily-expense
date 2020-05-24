<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractApiController extends AbstractController
{
    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function responseBadRequestWithMessage(string $message): JsonResponse
    {
        return $this->json(['message' => $message], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param array $error
     *
     * @return JsonResponse
     */
    protected function responseBadRequestWithErrorDetail(array $error): JsonResponse
    {
        return $this->json(['error' => $error], Response::HTTP_BAD_REQUEST,);
    }

    /**
     * @return JsonResponse
     */
    protected function responseSuccessWithNoContent(): JsonResponse
    {
        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
