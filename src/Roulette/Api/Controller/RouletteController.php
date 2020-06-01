<?php

namespace Roulette\Api\Controller;

use Identity\Model\User;
use Lib\HttpFoundation\Fail;
use Lib\HttpFoundation\Result;
use Lib\HttpFoundation\Success;
use Lib\QueryObject\Listing;
use Lib\QueryObject\QueryExecutor;
use Roulette\Application\Command\Spin;
use Roulette\Application\QueryObject\PlayersActivityQO;
use Roulette\Application\QueryObject\RoundsStatisticQO;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1/roulette")
 */
class RouletteController
{
    private ValidatorInterface $validator;
    private User $user;
    private MessageBusInterface $commandBus;
    private LockFactory $lockFactory;
    private QueryExecutor $queryExecutor;

    public function __construct(
        ValidatorInterface $validator,
        MessageBusInterface $commandBus,
        TokenStorageInterface $tokenStorage,
        LockFactory $lockFactory,
        QueryExecutor $queryExecutor
    )
    {
        $this->validator = $validator;
        // in real project can be resolved through e.g. argument resolver
        $this->user = $tokenStorage->getToken()->getUser()->getUser();
        $this->commandBus = $commandBus;
        $this->lockFactory = $lockFactory;
        $this->queryExecutor = $queryExecutor;
    }

    /**
     * @Route("/spin", methods={"POST"})
     * @param Spin $command
     *
     * @return Result
     */
    public function spin(Spin $command): Result
    {
        $command->playerId = $this->user->id();
        $errors = $this->validator->validate($command);
        if (count($errors) > 0) {
            return Fail::fromValidation($errors);
        }

        $lock = $this->lockFactory->createLock('roulette');
        if ($lock->acquire()) {
            $this->commandBus->dispatch($command);
            $lock->release();
        }

        return Success::ok();
    }

    /**
     * @Route("/statistic/rounds", methods={"GET"})
     *
     * @return Result
     */
    public function roundsStatistic(): Result
    {
        return new Success(
            new Listing($this->queryExecutor->execute(new RoundsStatisticQO()))
        );
    }

    /**
     * @Route("/players-activity", methods={"GET"})
     *
     * @return Result
     */
    public function playersActivity(): Result
    {
        return new Success(
            new Listing($this->queryExecutor->execute(new PlayersActivityQO()))
        );
    }
}