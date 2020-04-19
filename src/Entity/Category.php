<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
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
     * @param ArrayCollection $children
     *
     * @return Category
     */
    public function setChildren(ArrayCollection $children): Category
    {
        $this->children = $children;

        return $this;
    }
}
