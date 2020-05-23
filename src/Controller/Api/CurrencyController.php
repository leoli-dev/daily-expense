<?php

namespace App\Controller\Api;

use App\Entity\Currency;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends AbstractController
{
    /**
     * @param Currency $currency
     *
     * @return JsonResponse
     */
    public function fetch(Currency $currency): JsonResponse
    {
        return $this->json(['currency' => $currency]);
    }

    /**
     * @param Request  $request
     * @param Currency $currency
     *
     * @return JsonResponse
     */
    public function update(
        Request $request,
        Currency $currency
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['id']) || !isset($data['name'])
            || !isset($data['code']) || !isset($data['symbol'])) {
            return $this->json([], Response::HTTP_BAD_REQUEST);
        }
        $currency
            ->setName($data['name'])
            ->setCode($data['code'])
            ->setSymbol($data['symbol']);
        $manager = $this->getDoctrine()->getManager();
        $manager->flush();

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
