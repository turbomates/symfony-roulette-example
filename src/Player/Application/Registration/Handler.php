<?php
declare(strict_types=1);

namespace Player\Application\Registration;

use Doctrine\ORM\EntityManagerInterface;
use Player\Model\Name;
use Player\Model\Player;
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

    public function register(Register $command)
    {
        $this->entityManager->persist(
            Player::register(
                $command->username,
                new Name($command->firstName, $command->lastName),
                $command->password
            )
        );
    }

    public static function getHandledMessages(): iterable
    {
        yield Register::class => [
            'method' => 'register',
            'bus' => 'command',
        ];
    }
}