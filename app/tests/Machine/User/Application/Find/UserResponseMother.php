<?php


namespace VendingMachine\Tests\Machine\User\Application\Find;


use VendingMachine\Machine\User\Application\Find\UserResponse;
use VendingMachine\Machine\User\Domain\UserCoins;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Machine\User\Domain\UserType;
use VendingMachine\Tests\Machine\User\Domain\UserCoinsMother;
use VendingMachine\Tests\Machine\User\Domain\UserIdMother;
use VendingMachine\Tests\Machine\User\Domain\UserTypeMother;

final class UserResponseMother
{
    public static function create(
        ?UserId $id = null,
        ?UserCoins $coins = null,
        ?UserType $type = null
    ): UserResponse
    {
        return new UserResponse(
            $id?->value() ?? UserIdMother::create()->value(),
            $coins?->toPrimitives() ?? UserCoinsMother::createWithCoins()->toPrimitives(),
            $type?->value() ?? UserTypeMother::create()
        );
    }

}
