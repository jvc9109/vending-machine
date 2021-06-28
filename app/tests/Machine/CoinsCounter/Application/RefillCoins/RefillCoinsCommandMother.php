<?php


namespace VendingMachine\Tests\Machine\CoinsCounter\Application\RefillCoins;


use VendingMachine\Machine\CoinsCounter\Application\RefillCoins\RefillCoinsCommand;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterIdMother;
use VendingMachine\Tests\Shared\Domain\MotherCreator;

final class RefillCoinsCommandMother
{
    public static function create(?CoinsCounterId $id = null, ?int $amount = null): RefillCoinsCommand
    {
        return new RefillCoinsCommand(
            $id?->value() ?? CoinsCounterIdMother::create()->value(),
            $amount ?? MotherCreator::random()->randomNumber()
        );
    }
}
