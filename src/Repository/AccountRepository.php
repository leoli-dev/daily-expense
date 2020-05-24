<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Common\Persistence\ManagerRegistry;

class AccountRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }
}
