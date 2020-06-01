<?php
declare(strict_types=1);

namespace Player\Model\Event;

use Lib\Model\Event;

final class Registered implements Event
{
    public string $id;
    public string $username;
    public string $password;

    public function __construct(string $id, string $username, string $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }
}