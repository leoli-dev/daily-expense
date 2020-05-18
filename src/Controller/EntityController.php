<?php

namespace App\Controller;

use App\Entity\Currency;
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
        return $this->render('pages/entities/accounts.html.twig');
    }

    /**
     * @return Response
     */
    public function owners(): Response
    {
        return $this->render('pages/entities/owners.html.twig');
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
