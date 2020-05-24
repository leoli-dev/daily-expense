<?php

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Common\Persistence\ManagerRegistry;

class CurrencyRepository extends AbstractRepository
{
    /**
     * CurrencyRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Currency::class);
    }
}
