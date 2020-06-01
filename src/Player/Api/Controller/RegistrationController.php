<?php
declare(strict_types=1);

namespace Player\Api\Controller;

use Lib\HttpFoundation\Fail;
use Lib\HttpFoundation\Result;
use Lib\HttpFoundation\Success;
use Player\Application\Registration\Register;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1/player")
 */
class RegistrationController
{
    private MessageBusInterface $commandBus;
    private ValidatorInterface $validator;

    public function __construct(MessageBusInterface $commandBus, ValidatorInterface $validator)
    {
        $this->commandBus = $commandBus;
        $this->validator = $validator;
    }

    /**
     * @Route("/register", methods={"POST"})
     * @param Register $command
     *
     * @return Result
     */
    public function register(Register $command): Result
    {
        $errors = $this->validator->validate($command);
        if (count($errors) > 0) {
            return Fail::fromValidation($errors);
        }
        $this->commandBus->dispatch($command);

        return Success::ok();
    }
}