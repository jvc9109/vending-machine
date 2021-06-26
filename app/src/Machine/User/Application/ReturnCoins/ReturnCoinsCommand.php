<?php


namespace VendingMachine\Machine\User\Application\ReturnCoins;


use VendingMachine\Shared\Domain\Bus\Command\Command;

final class ReturnCoinsCommand implements Command
{


    public function __construct(private string $userId)
    {
    }

    public function userId(): string
    {
        return $this->userId;
    }

}
