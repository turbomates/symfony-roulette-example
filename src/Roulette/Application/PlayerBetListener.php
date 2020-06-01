<?php
declare(strict_types=1);

namespace Roulette\Application;

use Doctrine\ORM\EntityManagerInterface;
use Roulette\Model\Event\PlayerBet;
use Roulette\Model\GameStatistic;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PlayerBetListener implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private LockFactory $lockFactory;

    public function __construct(EntityManagerInterface $entityManager, LockFactory $lockFactory)
    {
        $this->entityManager = $entityManager;
        $this->lockFactory = $lockFactory;
    }

    public function __invoke(PlayerBet $event)
    {
        $lock = $this->lockFactory->createLock('games-statistic');
        // if we scale consumes
        if ($lock->acquire()) {
            $statistic = $this->entityManager->getRepository(GameStatistic::class)->findOneBy([
                'roundId' => $event->roundId,
                'playerId' => $event->playerId
            ]);
            if (!$statistic) {
                $statistic = new GameStatistic($event->roundId, $event->playerId);
            }
            $statistic->addNewGame();
            $this->entityManager->persist($statistic);

            $lock->release();
        }
    }
}