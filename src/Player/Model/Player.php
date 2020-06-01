<?php
declare(strict_types=1);

namespace Player\Model;

use Lib\Model\AggregateRoot;
use Player\Model\Event\Registered;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="players")
 * @ORM\Entity(repositoryClass="Player\Infrastructure\PlayerRepository")
 */
class Player extends AggregateRoot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=40, unique=true)
     */
    private string $username;

    /**
     * @ORM\Embedded(class="Player\Model\Name", columnPrefix=false)
     */
    private Name $name;

    // other player fields e.g. affiliate code

    private function __construct(string $id, string $username, Name $name)
    {
        $this->id = $id;
        $this->username = $username;
        $this->name = $name;
    }

    public static function register(string $username, Name $name, string $rawPassword): self
    {
        $player = new self(uuid_create(), $username, $name);
        $player->addEvent(new Registered($player->id, $username, $rawPassword));

        return $player;
    }
}