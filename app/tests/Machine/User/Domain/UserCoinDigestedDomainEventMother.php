<?php


namespace VendingMachine\Tests\Machine\User\Domain;


use VendingMachine\Machine\User\Domain\UserCoinDigestedDomainEvent;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;
use VendingMachine\Tests\Shared\Domain\RandomElementPicker;

final class UserCoinDigestedDomainEventMother
{
    public static function create(?UserId $id = null, ?float $coinValue = null): UserCoinDigestedDomainEvent
    {
        return new UserCoinDigestedDomainEvent(
            $id?->value() ?? UserIdMother::create()->value(),
            $coinValue ?? RandomElementPicker::from(...CoinValueObject::VALID_COINS)
        );
    }
}
