<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements userinterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private string $nickname;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private string $password;

    /**
     * @var string
     */
    private string $plainPassword;

    /**
     * @ORM\Column(type="json")
     *
     * @var array
     */
    private array $roles = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has role_user
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return User
     */
    public function setPlainPassword(string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     *
     * @return User
     */
    public function setNickname(string $nickname): User
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function eraseCredentials(): void
    {
    }
}
