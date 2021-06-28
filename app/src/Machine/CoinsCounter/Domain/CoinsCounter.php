<?php


namespace VendingMachine\Machine\CoinsCounter\Domain;


use VendingMachine\Shared\Domain\Aggregate\AggregateRoot;

final class CoinsCounter extends AggregateRoot
{

    public function __construct(
        private CoinsCounterId $id,
        private CoinsCounterCoinValue $coin,
        private CoinsCounterTotalCoins $totalCoins
    )
    {
        parent::__construct();
    }

    public static function initialize(string $id, float $coin): self
    {
        return new self(new CoinsCounterId($id), new CoinsCounterCoinValue($coin), CoinsCounterTotalCoins::initialize());
    }

    public function refill(int $amount): void
    {
        $this->totalCoins = new CoinsCounterTotalCoins($this->totalCoins->value() + $amount);
    }

    public function increment(): void
    {
        $this->totalCoins = $this->totalCoins->increment();
    }

    public function decrement(): void
    {
        $this->totalCoins = $this->totalCoins->decrement();
    }

    public function id(): CoinsCounterId
    {
        return $this->id;
    }

    public function coin(): CoinsCounterCoinValue
    {
        return $this->coin;
    }

    public function totalCoins(): CoinsCounterTotalCoins
    {
        return $this->totalCoins;
    }

}
