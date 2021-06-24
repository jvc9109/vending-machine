<?php


namespace VendingMachine\Tests\Machine\User\Domain;


use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Tests\Shared\Domain\UuidMother;

final class UserIdMother
{
    public static function create(?string $value = null): UserId
    {
        return new UserId($value ?? UuidMother::create());
    }
}
