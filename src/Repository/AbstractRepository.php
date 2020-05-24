<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * @param string   $uniqueFiled
     * @param mixed    $value
     * @param int|null $currentEntityId
     *
     * @return bool
     */
    public function checkUniqueFieldConflict(
        string $uniqueFiled,
        $value,
        ?int $currentEntityId = null
    ): bool {
        $existEntity = $this->findOneBy([$uniqueFiled => $value]);
        if (is_null($existEntity) || $existEntity->getId() === $currentEntityId) {
            return true;
        }

        return false;
    }
}
