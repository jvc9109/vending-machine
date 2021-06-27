<?php


namespace VendingMachine\Machine\User\Domain;


use VendingMachine\Shared\Domain\Bus\Event\DomainEvent;

final class UserCoinGivenDomainEvent extends DomainEvent
{

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        // TODO: Implement fromPrimitives() method.
    }

    public static function eventName(): string
    {
        // TODO: Implement eventName() method.
    }

    public function toPrimitives(): array
    {
        // TODO: Implement toPrimitives() method.
    }
}
