<?php

namespace App\Entity;

use App\Entity\Traits\CreationTrait;
use App\Entity\Traits\ModificationTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Record
{
    use CreationTrait;
    use ModificationTrait;

    public const FLOW_TYPE_INCOME = 0;
    public const FLOW_TYPE_EXPENSE = 1;
    public const FLOW_TYPE_TRANSFER = 2;
    public const FLOW_TYPES = [
        'income'    => self::FLOW_TYPE_INCOME,
        'expense'   => self::FLOW_TYPE_EXPENSE,
        'transfer'  => self::FLOW_TYPE_TRANSFER,
    ];


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
     * @ORM\Column(type="smallint")
     *
     * @var int
     */
    private int $flowType;

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
     * @return int
     */
    public function getFlowType(): int
    {
        return $this->flowType;
    }

    /**
     * @param int $flowType
     *
     * @return Record
     */
    public function setFlowType(int $flowType): Record
    {
        if (!in_array($flowType, self::FLOW_TYPES)) {
            throw new \LogicException(
                sprintf('Invalid Flow Type: %d', $flowType)
            );
        }

        $this->flowType = $flowType;

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
