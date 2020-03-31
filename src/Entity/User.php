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
     * @orm\id()
     * @orm\generatedvalue()
     * @orm\column(type="integer")
     */
    private int $id;

    /**
     * @orm\column(type="string", length=255)
     *
     * @var string
     */
    private string $username;

    /**
     * @orm\column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private string $nickname;

    /**
     * @orm\column(type="string", length=64)
     *
     * @var string
     */
    private string $password;

    /**
     * @orm\column(type="json")
     *
     * @var array
     */
    private array $roles = [];

    /**
     * @return int|null
     */
    public function getid(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getusername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setusername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getroles()
    {
        $roles = $this->roles;
        // guarantee every user at least has role_user
        $roles[] = 'role_user';

        return array_unique($roles);
    }

    /**
     * @return string
     */
    public function getpassword(): string
    {
        return $this->password;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     *
     * @return $this
     */
    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getsalt()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function erasecredentials()
    {
    }
}
