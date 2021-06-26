<?php


namespace VendingMachine\Tests\Machine\Item\Domain;


use VendingMachine\Machine\Items\Domain\ItemId;
use VendingMachine\Machine\Items\Domain\ItemPrice;
use VendingMachine\Machine\Items\Domain\ItemPurchasedDomainEvent;

final class ItemPurchasedDomainEventMother
{
    public static function create(?ItemId $id = null, ?ItemPrice $price = null): ItemPurchasedDomainEvent
    {
        return new ItemPurchasedDomainEvent(
            $id?->value() ?? ItemIdMother::create()->value(),
            $price?->value() ?? ItemPriceMother::create()->value()
        );
    }
}
