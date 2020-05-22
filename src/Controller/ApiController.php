<?php

namespace App\Controller;

use App\Entity\Currency;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getCurrency(int $id): JsonResponse
    {
        $currencyRepo = $this->getDoctrine()->getRepository(Currency::class);
        $currency = $currencyRepo->find($id);
        if (!$currency instanceof Currency) {
            return $this->json(null, Response::HTTP_BAD_REQUEST);
        }
        return $this->json(['currency' => $currency]);
    }
}
