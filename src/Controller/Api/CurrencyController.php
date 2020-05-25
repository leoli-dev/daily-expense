<?php

namespace App\Controller\Api;

use App\Entity\Currency;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CurrencyController extends AbstractApiController
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
        if (!isset($data['name']) || !isset($data['code']) || !isset($data['symbol'])) {
            return $this->responseBadRequestWithMessage('Invalid parameters.');
        }

        $name = $data['name'];
        $code = $data['code'];
        $symbol = $data['symbol'];
        $manager = $this->getDoctrine()->getManager();
        $currencyRepo = $manager->getRepository(Currency::class);
        $error = [];
        if (!$currencyRepo->checkUniqueFieldConflict('name', $name, $currency->getId())) {
            $error['name'] = sprintf('Currency with name "%s" exists already.', $name);
        }
        if (!$currencyRepo->checkUniqueFieldConflict('code', $code, $currency->getId())) {
            $error['code'] = sprintf('Currency with code "%s" exists already.', $code);
        }
        if (!empty($error)) {
            return $this->responseBadRequestWithErrorDetail($error);
        }

        $currency
            ->setName($name)
            ->setCode($code)
            ->setSymbol($symbol);
        $manager->flush();

        return $this->responseSuccessWithNoContent();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['name']) || !isset($data['code']) || !isset($data['symbol'])) {
            return $this->responseBadRequestWithMessage('Invalid parameters.');
        }
        $name = $data['name'];
        $code = $data['code'];
        $symbol = $data['symbol'];
        $manager = $this->getDoctrine()->getManager();
        $currencyRepo = $manager->getRepository(Currency::class);
        $error = [];
        if (!$currencyRepo->checkUniqueFieldConflict('name', $name)) {
            $error['name'] = sprintf('Currency with name "%s" exists already.', $name);
        }
        if (!$currencyRepo->checkUniqueFieldConflict('code', $code)) {
            $error['code'] = sprintf('Currency with code "%s" exists already.', $code);
        }
        if (!empty($error)) {
            $this->responseBadRequestWithErrorDetail($error);
        }

        $currency = new Currency();
        $currency
            ->setName($name)
            ->setCode($code)
            ->setSymbol($symbol);
        $manager->persist($currency);
        $manager->flush();

        return $this->json(['currency' => $currency]);
    }

    /**
     * @param Currency $currency
     *
     * @return JsonResponse
     */
    public function delete(Currency $currency): JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($currency);
        try {
            $manager->flush();
        } catch (ForeignKeyConstraintViolationException $exception) {
            return $this->responseBadRequestWithMessage(
                'Delete failed! This currency is still being used by other entity.'
            );
        }

        return $this->responseSuccessWithNoContent();
    }
}
