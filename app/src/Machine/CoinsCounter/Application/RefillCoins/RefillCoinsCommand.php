<?php


namespace VendingMachine\Machine\CoinsCounter\Application\RefillCoins;


use VendingMachine\Shared\Domain\Bus\Command\Command;

final class RefillCoinsCommand implements Command
{


    public function __construct(
        private string $counterId,
        private int $amount
    )
    {
    }

    public function counterId(): string
    {
        return $this->counterId;
    }

    public function amount(): int
    {
        return $this->amount;
    }

}
