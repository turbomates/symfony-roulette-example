<?php
declare(strict_types=1);

namespace Roulette\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Lib\Model\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;
use Roulette\Model\Event\PlayerBet;

/**
 * @ORM\Table(name="rounds")
 * @ORM\Entity(repositoryClass="Roulette\Infrastructure\RoundRepository")
 */
class Round extends AggregateRoot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime", name="started_at")
     */
    private \DateTime $startedAt;

    /**
     * @var array<int, int>
     * @ORM\Column(type="json", options={"jsonb": true})
     */
    private array $results;

    /**
     * @ORM\OneToMany(targetEntity="Game", mappedBy="roundId", cascade={"persist"})
     */
    private $games;

    /**
     * @ORM\Embedded(class="Status", columnPrefix=false)
     */
    private Status $status;

    private function __construct()
    {
        $this->results = [];
        $this->startedAt = new \DateTime();
        $this->games = new ArrayCollection();
        $this->status = Status::active();
    }

    public static function start(): self
    {
        return new self();
    }

    public function bet(Roulette $roulette, string $playerId, int $number)
    {
        $result = $roulette->spin();
        $this->games->add(new Game($playerId, $this->id, $number, $result->droppedCell()));
        if ($result->isJackpot()) {
            $this->status->finish();
        } else $this->saveResult($result);
        $this->addEvent(new PlayerBet($this->id, $playerId));
    }


    /**
     * @return array<int, int>
     */
    public function results(): array {
        return $this->results;
    }

    private function saveResult(Result $result)
    {
        $droppedCell = $result->droppedCell();
        $previousResult = $this->results[$droppedCell] ?? 0;
        $this->results[$droppedCell] = ++$previousResult;
    }
}