<?php


namespace VendingMachine\Machine\User\Application\InitSession;


use VendingMachine\Shared\Domain\Bus\Command\Command;

final class InitSessionCommand implements Command
{
    public function __construct(private string $userId)
    {
    }

    public function userId(): string
    {
        return $this->userId;
    }
}
