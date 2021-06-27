<?php


namespace VendingMachine\Tests\Machine\CoinsCounter\Domain;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterCoinValue;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;
use VendingMachine\Tests\Shared\Domain\RandomElementPicker;

final class CoinsCounterCoinValueMother
{
    public static function create(?float $value = null): CoinsCounterCoinValue
    {
        return new CoinsCounterCoinValue($value ?? RandomElementPicker::from(...CoinValueObject::VALID_COINS));
    }
}
