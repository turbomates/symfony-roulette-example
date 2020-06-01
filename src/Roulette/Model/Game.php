<?php
declare(strict_types=1);

namespace Roulette\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="games")
 * @ORM\Entity()
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    private string $id;

    /**
     * @ORM\Column(type="datetime", name="started_at")
     */
    private \DateTime $startedAt;

    /**
     * @ORM\Column(type="guid", name="player_id")
     */
    private string $playerId;

    /**
     * @ORM\Column(type="bigint", name="round_id")
     */
    private int $roundId;

    /**
     * @ORM\Column(type="integer", name="player_number")
     */
    private int $playerNumber;

    /**
     * @ORM\Column(type="integer", name="win_number")
     */
    private int $winNumber;

    public function __construct(string $playerId, int $roundId, int $playerNumber, int $winNumber)
    {
        $this->id = uuid_create();
        $this->startedAt = new \DateTime();
        $this->playerId = $playerId;
        $this->roundId = $roundId;
        $this->playerNumber = $playerNumber;
        $this->winNumber = $winNumber;
    }

    public function playerId(): string
    {
        return $this->playerId;
    }
}