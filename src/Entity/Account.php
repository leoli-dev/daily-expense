<?php

namespace App\Entity;

use App\Entity\Traits\CreationTrait;
use App\Entity\Traits\ModificationTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Account
{
    use CreationTrait;
    use ModificationTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private string $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Account
     */
    public function setName(string $name): Account
    {
        $this->name = $name;

        return $this;
    }
}
