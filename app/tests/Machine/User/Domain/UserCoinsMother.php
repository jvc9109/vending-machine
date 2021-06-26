<?php


namespace VendingMachine\Tests\Machine\User\Domain;


use VendingMachine\Machine\User\Domain\UserCoins;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;
use VendingMachine\Tests\Shared\Domain\MotherCreator;
use VendingMachine\Tests\Shared\Domain\RandomElementPicker;

final class UserCoinsMother
{
    public static function empty(): UserCoins
    {
        return new UserCoins([]);
    }

    public static function createWithCoins(): UserCoins
    {
        $coins      = [];
        $totalCoins = MotherCreator::random()->numberBetween(0, 5);
        for ($i = 1; $i <= $totalCoins; $i++) {
            $coins[] = new CoinValueObject(RandomElementPicker::from(...CoinValueObject::VALID_COINS));
        }

        return new UserCoins($coins);
    }
}
