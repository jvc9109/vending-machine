<?php


namespace VendingMachine\Tests\Machine\CoinsCounter\Domain;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Tests\Shared\Domain\UuidMother;

final class CoinsCounterIdMother
{
    public static function create(?string $value = null): CoinsCounterId
    {
        return new CoinsCounterId($value ?? UuidMother::create());
    }
}
