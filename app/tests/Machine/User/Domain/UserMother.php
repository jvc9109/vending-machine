<?php


namespace VendingMachine\Tests\Machine\User\Domain;


use VendingMachine\Machine\User\Domain\User;
use VendingMachine\Machine\User\Domain\UserCoins;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Machine\User\Domain\UserType;

final class UserMother
{

    public static function create(
        ?UserId $id = null,
        ?UserCoins $coins = null,
        ?UserType $type = null
    ): User
    {
        return new User(
            $id ?? UserIdMother::create(),
            $coins ?? UserCoinsMother::empty(),
            $type ?? UserTypeMother::create()
        );
    }

}
