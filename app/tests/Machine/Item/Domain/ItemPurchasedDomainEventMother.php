<?php


namespace VendingMachine\Tests\Machine\Item\Domain;


use VendingMachine\Machine\Items\Domain\ItemId;
use VendingMachine\Machine\Items\Domain\ItemPrice;
use VendingMachine\Machine\Items\Domain\ItemPurchasedDomainEvent;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Tests\Machine\User\Domain\UserIdMother;

final class ItemPurchasedDomainEventMother
{
    public static function create(
        ?ItemId $id = null,
        ?ItemPrice $price = null,
        ?UserId $userId = null
    ): ItemPurchasedDomainEvent
    {
        return new ItemPurchasedDomainEvent(
            $id?->value() ?? ItemIdMother::create()->value(),
            $price?->value() ?? ItemPriceMother::create()->value(),
            $userId?->value() ?? UserIdMother::create()->value()
        );
    }
}
