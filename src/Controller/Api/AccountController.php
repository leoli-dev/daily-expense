<?php

namespace App\Controller\Api;

use App\Entity\Account;
use App\Entity\Currency;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends AbstractApiController
{
    /**
     * @param Account $account
     *
     * @return JsonResponse
     */
    public function fetch(Account $account): JsonResponse
    {
        return $this->json(['account' => $account]);
    }

    /**
     * @param Request $request
     * @param Account $account
     *
     * @return JsonResponse
     */
    public function update(
        Request $request,
        Account $account
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['name'])
            || !isset($data['currency'])
            || 0 === $currencyId = intval($data['currency'])) {
            return $this->responseBadRequestWithMessage('Invalid parameters.');
        }

        $manager = $this->getDoctrine()->getManager();
        $currencyRepo = $manager->getRepository(Currency::class);
        $currency = $currencyRepo->find($currencyId);
        if (!$currency instanceof Currency) {
            return $this->responseBadRequestWithMessage('Invalid parameters.');
        }

        $error = [];
        $name = $data['name'];
        if (!$currencyRepo->checkUniqueFieldConflict('name', $name, $account->getId())) {
            $error['name'] = sprintf('Account with name "%s" exists already.', $name);
        }
        if (!empty($error)) {
            return $this->responseBadRequestWithErrorDetail($error);
        }

        $account
            ->setName($name)
            ->setCurrency($currency)
            ->setModifiedAt(new \DateTimeImmutable());
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
        if (!isset($data['name'])
            || !isset($data['currency'])
            || 0 === $currencyId = intval($data['currency'])) {
            return $this->responseBadRequestWithMessage('Invalid parameters.');
        }

        $manager = $this->getDoctrine()->getManager();
        $currencyRepo = $manager->getRepository(Currency::class);
        $currency = $currencyRepo->find($currencyId);
        if (!$currency instanceof Currency) {
            return $this->responseBadRequestWithMessage('Invalid parameters.');
        }

        $error = [];
        $name = $data['name'];
        if (!$currencyRepo->checkUniqueFieldConflict('name', $name)) {
            $error['name'] = sprintf('Account with name "%s" exists already.', $name);
        }
        if (!empty($error)) {
            return $this->responseBadRequestWithErrorDetail($error);
        }

        $account = new Account();
        $account
            ->setName($name)
            ->setCurrency($currency)
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($account);
        $manager->flush();

        return $this->json(['account' => $account]);
    }

    /**
     * @param Account $account
     *
     * @return JsonResponse
     */
    public function delete(Account $account): JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($account);
        try {
            $manager->flush();
        } catch (ForeignKeyConstraintViolationException $exception) {
            return $this->responseBadRequestWithMessage(
                'Delete failed! This account is still being used by other entity.'
            );
        }

        return $this->responseSuccessWithNoContent();
    }
}
