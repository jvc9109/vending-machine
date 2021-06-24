<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure\Bus\Event\RabbitMq;

use VendingMachine\Shared\Domain\Bus\Event\DomainEvent;
use VendingMachine\Tests\Shared\Domain\UuidMother;

final class FakeDomainEvent extends DomainEvent
{

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        return new self($aggregateId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'fake name';
    }

    public static function random(): FakeDomainEvent
    {
        return new self(
            UuidMother::create()
        );
    }

    public function toPrimitives(): array
    {
        return [];
    }
}
