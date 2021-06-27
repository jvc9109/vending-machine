<?php


namespace VendingMachine\Machine\User\Domain;


use VendingMachine\Shared\Domain\Bus\Event\DomainEvent;

final class UserCoinGivenDomainEvent extends DomainEvent
{

    public function __construct(
        string $aggregateId,
        private string $coinCounterId,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        return new self($aggregateId, $body['coinCounterId'], $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'vending.machine.user.coin_given';
    }

    public function toPrimitives(): array
    {
        return [
          'coinCounterId' => $this->coinCounterId
        ];
    }

    public function coinCounterId(): string
    {
        return $this->coinCounterId;
    }
}
