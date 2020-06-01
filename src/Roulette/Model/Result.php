<?php
declare(strict_types=1);

namespace Roulette\Model;

class Result
{
    private const JACKPOT = -1;
    private int $cell;

    public function __construct(int $cell)
    {
        $this->cell = $cell;
    }

    public static function jackpot(): self
    {
        return new self(self::JACKPOT);
    }

    public function isJackpot(): bool
    {
        return $this->cell == self::JACKPOT;
    }

    public function droppedCell(): int
    {
        return $this->cell;
    }
}