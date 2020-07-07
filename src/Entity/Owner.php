<?php

namespace App\Entity;

use App\Entity\Traits\CreationTrait;
use App\Entity\Traits\ModificationTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OwnerRepository")
 */
class Owner implements \JsonSerializable
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
     * @ORM\Column(type="string", unique=true)
     *
     * @var string
     */
    private string $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private ?string $icon;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Owner
     */
    public function setName(string $name): Owner
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     *
     * @return Owner
     */
    public function setIcon(?string $icon): Owner
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => $this->icon,
        ];
    }
}
