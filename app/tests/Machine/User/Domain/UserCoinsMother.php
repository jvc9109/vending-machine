<?php


namespace VendingMachine\Tests\Machine\User\Domain;


use VendingMachine\Machine\User\Domain\UserCoins;

final class UserCoinsMother
{
    public static function empty(): UserCoins
    {
        return new UserCoins([]);
    }
}
