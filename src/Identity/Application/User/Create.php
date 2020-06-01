<?php
declare(strict_types=1);

namespace Identity\Application\User;

class Create
{
    public string $id;
    public string $username;
    public string $rawPassword;

    public function __construct(string $id, string $username, string $rawPassword)
    {
        $this->id = $id;
        $this->username = $username;
        $this->rawPassword = $rawPassword;
    }
}