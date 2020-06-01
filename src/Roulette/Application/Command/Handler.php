<?php
declare(strict_types=1);

namespace Roulette\Application\Command;

use Doctrine\ORM\EntityManagerInterface;
use Roulette\Application\MagicRoulette;
use Roulette\Model\Round;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class Handler implements MessageSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function spin(Spin $command)
    {
        $round = $this->entityManager->getRepository(Round::class)->findActive();
        if (!$round) {
            $round = Round::start();
            $this->entityManager->persist($round);
        }

        $roulette = MagicRoulette::prepare($round->results());
        $round->bet($roulette, $command->playerId, $command->number);
    }

    public static function getHandledMessages(): iterable
    {
        yield Spin::class => [
            'method' => 'spin',
            'bus' => 'command',
        ];
    }
}