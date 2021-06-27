<?php


namespace VendingMachine\Machine\CoinsCounter\Application\GetAllCounters;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounter;

final class CoinsCounterResponseConverter
{

    public static function fromCounter(CoinsCounter $counter): CoinsCounterResponse
    {
        return new CoinsCounterResponse(
            $counter->id()->value(),
            $counter->coin()->value(),
            $counter->totalCoins()->value()
        );
    }
}
