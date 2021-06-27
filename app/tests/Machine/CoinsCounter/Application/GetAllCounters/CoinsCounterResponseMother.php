<?php


namespace VendingMachine\Tests\Machine\CoinsCounter\Application\GetAllCounters;


use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\CoinsCounterResponse;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterCoinValue;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterTotalCoins;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterCoinValueMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterIdMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterTotalCoinsMother;

final class CoinsCounterResponseMother
{
    public static function create(
        ?CoinsCounterId $id = null,
        ?CoinsCounterCoinValue $coinValue = null,
        ?CoinsCounterTotalCoins $totalCoins = null
    ): CoinsCounterResponse
    {
        return new CoinsCounterResponse(
            $id?->value() ?? CoinsCounterIdMother::create()->value(),
            $coinValue?->value() ?? CoinsCounterCoinValueMother::create()->value(),
            $totalCoins?->value() ?? CoinsCounterTotalCoinsMother::create()->value()
        );
    }
}
