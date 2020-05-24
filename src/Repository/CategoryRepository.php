<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Common\Persistence\ManagerRegistry;

class CategoryRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
}
