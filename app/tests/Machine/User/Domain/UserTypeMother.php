<?php


namespace VendingMachine\Tests\Machine\User\Domain;


use VendingMachine\Machine\User\Domain\UserType;
use VendingMachine\Tests\Shared\Domain\RandomElementPicker;

final class UserTypeMother
{
    public static function create(?string $value = null): UserType
    {
        return new UserType($value ?? RandomElementPicker::from(...[UserType::user()->value(), UserType::service()->value()]));
    }

    public static function createUser(): UserType
    {
        return self::create(UserType::user()->value());
    }
}
