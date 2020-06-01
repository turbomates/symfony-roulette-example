<?php
declare(strict_types=1);

namespace Identity\Application;

use Identity\Application\User\Create;
use Player\Model\Event\Registered;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class PlayerRegisteredListener implements MessageHandlerInterface
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Registered $event)
    {
        $this->commandBus->dispatch(new Create($event->id, $event->username, $event->password));
    }
}