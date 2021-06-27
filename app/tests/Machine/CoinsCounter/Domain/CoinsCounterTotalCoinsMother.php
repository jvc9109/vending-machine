<?php


namespace VendingMachine\Tests\Machine\CoinsCounter\Domain;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterTotalCoins;
use VendingMachine\Tests\Shared\Domain\MotherCreator;

final class CoinsCounterTotalCoinsMother
{
    public static function create(?int $value = null): CoinsCounterTotalCoins
    {
        return new CoinsCounterTotalCoins($value ?? MotherCreator::random()->randomNumber());
    }
}
