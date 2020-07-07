<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Currency;
use App\Entity\Owner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class EntityController extends AbstractController
{
    /**
     * @return Response
     */
    public function categories(): Response
    {
        return $this->render('pages/entities/categories.html.twig');
    }

    /**
     * @return Response
     */
    public function accounts(): Response
    {
        $accountRepo = $this->getDoctrine()->getRepository(Account::class);
        $accounts = $accountRepo->findAll();

        return $this->render(
            'pages/entities/accounts.html.twig',
            [
                'accounts' => $accounts,
            ]
        );
    }

    /**
     * @return Response
     */
    public function owners(): Response
    {
        $ownerRepo = $this->getDoctrine()->getRepository(Owner::class);
        $owners = $ownerRepo->findAll();

        return $this->render(
            'pages/entities/owners.html.twig',
            [
                'owners' => $owners,
            ]
        );
    }

    /**
     * @return Response
     */
    public function records(): Response
    {
        return $this->render('pages/entities/records.html.twig');
    }

    /**
     * @return Response
     */
    public function currencies(): Response
    {
        $currencyRepo = $this->getDoctrine()->getRepository(Currency::class);
        $currencies = $currencyRepo->findAll();

        return $this->render(
            'pages/entities/currencies.html.twig',
            [
                'currencies' => $currencies,
            ]
        );
    }
}
