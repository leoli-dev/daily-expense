<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ModificationTrait
{
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     *
     * @var \DateTimeImmutable|null
     */
    protected ?\DateTimeImmutable $modifiedAt;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    /**
     * @param \DateTimeImmutable|null $modifiedAt
     *
     * @return $this
     */
    public function setModifiedAt(?\DateTimeImmutable $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }
}
