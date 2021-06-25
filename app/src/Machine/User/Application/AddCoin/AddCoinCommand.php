<?php


namespace VendingMachine\Machine\User\Application\AddCoin;


use VendingMachine\Shared\Domain\Bus\Command\Command;

final class AddCoinCommand implements Command
{


    public function __construct(
        private string $userId,
        private float $value
    )
    {
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function value(): float
    {
        return $this->value;
    }

}
