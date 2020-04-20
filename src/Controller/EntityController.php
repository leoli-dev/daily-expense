<?php

namespace App\Controller;

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
}
