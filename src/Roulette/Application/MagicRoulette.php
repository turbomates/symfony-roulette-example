<?php
declare(strict_types=1);

namespace Roulette\Application;

use Roulette\Model\Result;
use Roulette\Model\Roulette;

class MagicRoulette implements Roulette
{
    private const CELL_KINDS_COUNT = 10;
    private const CELLS_COUNT = 5;
    const TOTAL_CELLS = self::CELLS_COUNT * self::CELL_KINDS_COUNT + 1;

    /**
     * @var array<int, int>
     */
    private array $results;

    /**
     * @param array<int, int> $results
     */
    private function __construct(array $results)
    {
        $this->results = $results;
    }

    /**
     * @param array<int, int> $results
     *
     * @return static
     */
    public static function prepare(array $results): self
    {
        return new self($results);
    }

    public function spin(): Result
    {
        $leftCells = [];
        foreach ($this->sourceCells() as $key => $value) {
            $leftCells[$key] = $value - ($this->results[$key] ?? 0);
        }
        $magicBox = [];
        for ($i = 1; $i < self::CELL_KINDS_COUNT + 1; $i++) {
            $magicBox = array_merge($magicBox, array_fill(0, $i * $leftCells[$i], $i));
        }
        if (empty($magicBox)) return Result::jackpot();

        shuffle($magicBox);

        return new Result($magicBox[array_rand($magicBox)]);
    }

    /**
     * @return array<int, int>
     */
    private function sourceCells(): array
    {
        $cells = [];
        for ($i = 1; $i < self::CELL_KINDS_COUNT + 1; $i++) {
            $cells[$i] = self::CELLS_COUNT;
        }

        return $cells;
    }
}