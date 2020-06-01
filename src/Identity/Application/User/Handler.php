<?php
declare(strict_types=1);

namespace Identity\Application\User;

use Doctrine\ORM\EntityManagerInterface;
use Identity\Model\Password;
use Identity\Model\User;
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

    public function create(Create $command)
    {
        $this->entityManager->persist(
            User::create(
                $command->id,
                $command->username,
                Password::createEncoded($command->rawPassword)
            )
        );
    }

    public static function getHandledMessages(): iterable
    {
        yield Create::class => [
            'method' => 'create',
            'bus' => 'command',
        ];
    }
}