<?php


namespace App\Entity\Traits;

use App\Entity\User;
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
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="modified_by_id", referencedColumnName="id")
     *
     * @var User|null
     */
    protected ?User $modifiedBy;

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

    /**
     * @return User|null
     */
    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    /**
     * @param User|null $modifiedBy
     *
     * @return $this
     */
    public function setModifiedBy(?User $modifiedBy): self
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }
}
