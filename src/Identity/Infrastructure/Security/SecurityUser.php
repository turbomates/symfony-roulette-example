<?php
declare(strict_types=1);

namespace Identity\Infrastructure\Security;

use Identity\Model\User;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUser implements UserInterface
{
    private string $id;
    private string $username;
    private User $user;

    public function __construct(User $user, string $username)
    {
        $this->user = $user;
        $this->id = $user->id();
        $this->username = $username;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function id(): String
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRoles()
    {
        return ['ROLE_PLAYER'];
    }

    public function getPassword()
    {
        return false;
    }

    public function getSalt()
    {
        return false;
    }

    public function eraseCredentials()
    {
    }
}