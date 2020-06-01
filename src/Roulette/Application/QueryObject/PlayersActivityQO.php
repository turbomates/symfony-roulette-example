<?php
declare(strict_types=1);

namespace Roulette\Application\QueryObject;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Lib\QueryObject\QueryObject;
use Player\Model\Player;
use Roulette\Application\MagicRoulette;
use Roulette\Model\GameStatistic;

class PlayersActivityQO implements QueryObject
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
                's.playerId',
                'p.name.firstName as firstName',
                'p.name.lastName as lastName',
                'count(s.roundId) as rounds',
                'avg(s.gamesCount) / :totalGames  as averageSpins',
            ])
            ->from(GameStatistic::class, 's')
            ->innerJoin(Player::class, 'p', Join::WITH, 'p.id = s.playerId')
            // statistics in the future can be adapted to different types of roulette,
            // here simplified as part of the test task
            ->setParameter('totalGames', MagicRoulette::TOTAL_CELLS)
            ->groupBy('s.playerId, firstName, lastName')
            ->getQuery()
            ->getResult();
    }
}