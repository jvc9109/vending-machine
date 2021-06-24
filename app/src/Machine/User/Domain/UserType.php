<?php


namespace VendingMachine\Machine\User\Domain;


use InvalidArgumentException;
use VendingMachine\Shared\Domain\ValueObject\Enum;

/**
 * @method static UserType user()
 * @method static UserType service()
 */
final class UserType extends Enum
{
    public const USER    = 'user';
    public const SERVICE = 'service';

    protected function throwExceptionForInvalidValue(mixed $value): void
    {
        throw new InvalidArgumentException($value);
    }
}
