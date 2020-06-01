<?php
declare(strict_types=1);

namespace Roulette\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="games_statistic")
 * @ORM\Entity()
 */
class GameStatistic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     */
    private int $roundId;

    /**
     * @ORM\Id
     * @ORM\Column(type="guid", name="player_id")
     */
    private string $playerId;

    /**
     * @ORM\Column(type="integer", name="games_count")
     */
    private int $gamesCount;

    public function __construct(int $roundId, string $playerId)
    {
        $this->roundId = $roundId;
        $this->playerId = $playerId;
        $this->gamesCount = 0;
    }

    public function addNewGame()
    {
        $this->gamesCount++;
    }
}