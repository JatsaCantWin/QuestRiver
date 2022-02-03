<?php

class User
{
    private $email;
    private $password;
    private $username;
    private $rolename;

    public function __construct(string $email, string $password, string $username, string $rolename)
    {
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->rolename = $rolename;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getRolename(): string
    {
        return $this->rolename;
    }

    public function setRolename(string $rolename): void
    {
        $this->rolename = $rolename;
    }
}