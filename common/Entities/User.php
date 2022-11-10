<?php

namespace Common\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity @ORM\Table(name="users")
 */
class User
{
    /**  @ORM\Id @ORM\Column(type="integer", columnDefinition="INT AUTO_INCREMENT")  * */
    protected int $id;

    /** @ORM\Column(type="string") * */
    protected string $name;

    /** @ORM\Column(type="string") * */
    protected string $email;

    /** @ORM\Column(type="string") * */
    protected string $password;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

}