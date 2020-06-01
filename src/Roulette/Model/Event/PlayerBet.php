<?php
declare(strict_types=1);

namespace Roulette\Model\Event;

use Lib\Model\Event;

class PlayerBet implements Event
{
    public int $roundId;
    public string $playerId;

    public function __construct(int $roundId, string $playerId)
    {
        $this->roundId = $roundId;
        $this->playerId = $playerId;
    }
}