<?php


namespace VendingMachine\Machine\CoinsCounter\Application\InitNewCounter;


use VendingMachine\Shared\Domain\Bus\Command\Command;

final class InitNewCounterCommand implements Command
{


    public function __construct(
        private string $counterId,
        private float $coinValue
    )
    {
    }

    public function counterId(): string
    {
        return $this->counterId;
    }

    public function coinValue(): float
    {
        return $this->coinValue;
    }

}
