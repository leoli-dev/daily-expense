<?php

namespace App\Entity;

use App\Entity\Traits\CreationTrait;
use App\Entity\Traits\FlowTypeTrait;
use App\Entity\Traits\ModificationTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyRepository")
 */
class Record
{
    use CreationTrait;
    use ModificationTrait;
    use FlowTypeTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="float")
     *
     * @var float
     */
    private float $amount;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $happenedAt;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private string $description;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *
     * @var Category
     */
    private Category $category;

    /**
     * @ORM\ManyToOne(targetEntity="Owner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     *
     * @var Owner
     */
    private Owner $owner;

    /**
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     *
     * @var Account
     */
    private Account $account;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return Record
     */
    public function setAmount(float $amount): Record
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getHappenedAt(): \DateTimeImmutable
    {
        return $this->happenedAt;
    }

    /**
     * @param \DateTimeImmutable $happenedAt
     *
     * @return Record
     */
    public function setHappenedAt(\DateTimeImmutable $happenedAt): Record
    {
        $this->happenedAt = $happenedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Record
     */
    public function setDescription(string $description): Record
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     *
     * @return Record
     */
    public function setCategory(Category $category): Record
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Owner
     */
    public function getOwner(): Owner
    {
        return $this->owner;
    }

    /**
     * @param Owner $owner
     *
     * @return Record
     */
    public function setOwner(Owner $owner): Record
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     *
     * @return Record
     */
    public function setAccount(Account $account): Record
    {
        $this->account = $account;

        return $this;
    }
}
