<?php

namespace App\Entity;

use App\Entity\Traits\CreationTrait;
use App\Entity\Traits\FlowTypeTrait;
use App\Entity\Traits\ModificationTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category implements \JsonSerializable
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
     * @ORM\OneToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     *
     * @var Category|null
     */
    private ?Category $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     *
     * @var ArrayCollection
     */
    private ArrayCollection $children;

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
     * Category constructor.
     */
    public function __construct()
    {
        $this->parent = null;
        $this->children = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Category|null
     */
    public function getParent(): ?Category
    {
        return $this->parent;
    }

    /**
     * @param Category|null $parent
     *
     * @return Category
     */
    public function setParent(?Category $parent): Category
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren(): ArrayCollection
    {
        return $this->children;
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
     * @return Category
     */
    public function setName(string $name): Category
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
     * @return Category
     */
    public function setIcon(?string $icon): Category
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param ArrayCollection $children
     *
     * @return Category
     */
    public function setChildren(ArrayCollection $children): Category
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'parent' => $this->parent,
            'name' => $this->name,
            'icon' => $this->icon,
            'flowType' => $this->flowType,
        ];
    }
}
