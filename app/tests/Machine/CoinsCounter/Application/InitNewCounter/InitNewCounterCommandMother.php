<?php


namespace VendingMachine\Tests\Machine\CoinsCounter\Application\InitNewCounter;


use VendingMachine\Machine\CoinsCounter\Application\InitNewCounter\InitNewCounterCommand;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterCoinValue;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterCoinValueMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterIdMother;

final class InitNewCounterCommandMother
{
    public static function create(
        ?CoinsCounterId $id = null,
        ?CoinsCounterCoinValue $coinValue = null): InitNewCounterCommand
    {
        return new InitNewCounterCommand(
            $id?->value() ?? CoinsCounterIdMother::create()->value(),
            $coinValue?->value() ?? CoinsCounterCoinValueMother::create()->value()
        );
    }
}
