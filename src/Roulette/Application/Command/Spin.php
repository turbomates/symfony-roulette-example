<?php
declare(strict_types=1);

namespace Roulette\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;

class Spin
{
    /**
     * @Assert\NotNull()
     * @Assert\Range(min = 1, max = 10, minMessage="Min number is 1", maxMessage="Max number is 10")
     */
    public int $number;
    /**
     * @Assert\NotNull()
     * @Assert\Uuid
     */
    public string $playerId;
}