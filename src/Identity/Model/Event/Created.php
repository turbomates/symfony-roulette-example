<?php
declare(strict_types=1);

namespace Identity\Model\Event;

use Lib\Model\Event;

final class Created implements Event
{
    public string $id;
    public string $username;

    public function __construct(string $id, string $username)
    {
        $this->id = $id;
        $this->username = $username;
    }
}
