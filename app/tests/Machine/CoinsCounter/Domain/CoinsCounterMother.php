<?php


namespace VendingMachine\Tests\Machine\CoinsCounter\Domain;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounter;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterCoinValue;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterTotalCoins;

final class CoinsCounterMother
{
    public static function create(
        ?CoinsCounterId $id = null,
        ?CoinsCounterCoinValue $coinValue = null,
        ?CoinsCounterTotalCoins $totalCoins = null
    ): CoinsCounter
    {
        return new CoinsCounter(
            $id ?? CoinsCounterIdMother::create(),
            $coinValue ?? CoinsCounterCoinValueMother::create(),
            $totalCoins ?? CoinsCounterTotalCoinsMother::create()
        );
    }
}
