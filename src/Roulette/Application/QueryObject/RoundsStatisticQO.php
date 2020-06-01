<?php
declare(strict_types=1);

namespace Roulette\Application\QueryObject;

use Doctrine\ORM\EntityManagerInterface;
use Lib\QueryObject\QueryObject;
use Roulette\Model\GameStatistic;

class RoundsStatisticQO implements QueryObject
{
    /**
     * @param EntityManagerInterface $manager
     *
     * @return array
     */
    public function getData(EntityManagerInterface $manager): array
    {
        return $manager->createQueryBuilder()
            ->select([
                's.roundId',
                'count(s.playerId) as players',
            ])
            ->from(GameStatistic::class, 's')
            ->groupBy('s.roundId')
            ->orderBy('s.roundId')
            ->getQuery()
            ->getResult();
    }
}