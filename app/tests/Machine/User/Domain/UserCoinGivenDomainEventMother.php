<?php


namespace VendingMachine\Tests\Machine\User\Domain;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Machine\User\Domain\UserCoinGivenDomainEvent;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterIdMother;

final class UserCoinGivenDomainEventMother
{
    public static function create(?UserId $id = null, ?CoinsCounterId $counterId = null): UserCoinGivenDomainEvent
    {
        return new UserCoinGivenDomainEvent(
            $id?->value() ?? UserIdMother::create()->value(),
            $counterId?->value() ?? CoinsCounterIdMother::create()->value()
        );
    }
}
