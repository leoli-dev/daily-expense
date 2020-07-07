<?php

namespace App\Repository;

use App\Entity\Owner;
use Doctrine\Common\Persistence\ManagerRegistry;

class OwnerRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Owner::class);
    }
}
