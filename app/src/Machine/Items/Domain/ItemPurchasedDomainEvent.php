<?php


namespace VendingMachine\Machine\Items\Domain;


use VendingMachine\Shared\Domain\Bus\Event\DomainEvent;

final class ItemPurchasedDomainEvent extends DomainEvent
{

    public function __construct(
        string $aggregateId,
        private float $itemPrice,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        return new self(
            $aggregateId,
            $body['itemPrice'],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return 'vending.machine.item.purchased';
    }

    public function toPrimitives(): array
    {
        return [
            'itemPrice' => $this->itemPrice
        ];
    }

    public function itemPrice(): float
    {
        return $this->itemPrice;
    }


}
