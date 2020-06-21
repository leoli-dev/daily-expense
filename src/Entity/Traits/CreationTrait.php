<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait CreationTrait
{
    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @var \DateTimeImmutable
     */
    protected \DateTimeImmutable $createdAt;

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
