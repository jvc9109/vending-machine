<?php


namespace VendingMachine\Machine\User\Domain;


use VendingMachine\Shared\Domain\Bus\Event\DomainEvent;

final class UserCoinDigestedDomainEvent extends DomainEvent
{

    public function __construct(
        string $aggregateId,
        private float $coinValue,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        return new self($aggregateId, $body['coinValue'], $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'vending.machine.user.coin_digested';
    }

    public function toPrimitives(): array
    {
        return [
            'coinValue' => $this->coinValue
        ];
    }

    public function coinValue(): float
    {
        return $this->coinValue;
    }

}
