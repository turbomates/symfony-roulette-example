<?php
declare(strict_types=1);

namespace Roulette\Infrastructure;

use Doctrine\ORM\EntityRepository;
use Roulette\Model\Round;
use Roulette\Model\Status;

class RoundRepository extends EntityRepository
{
    /**
     * @return Round
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findActive(): ?Round
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.status.status = :status')
            ->setParameter('status', Status::ACTIVE)
            ->getQuery()
            ->getOneOrNullResult();
    }
}