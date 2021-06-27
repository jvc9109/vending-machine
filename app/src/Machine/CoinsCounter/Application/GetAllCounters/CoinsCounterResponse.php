<?php


namespace VendingMachine\Machine\CoinsCounter\Application\GetAllCounters;


use VendingMachine\Shared\Domain\Bus\Query\Response;

final class CoinsCounterResponse implements Response
{
    public function __construct(
        private string $id,
        private float $coinValue,
        private int $totalCoins
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function coinValue(): float
    {
        return $this->coinValue;
    }

    public function totalCoins(): int
    {
        return $this->totalCoins;
    }


}
