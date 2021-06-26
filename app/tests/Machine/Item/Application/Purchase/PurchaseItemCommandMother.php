<?php


namespace VendingMachine\Tests\Machine\Item\Application\Purchase;


use VendingMachine\Machine\Items\Application\Purchase\PurchaseItemCommand;
use VendingMachine\Machine\Items\Domain\ItemId;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Tests\Machine\Item\Domain\ItemIdMother;
use VendingMachine\Tests\Machine\User\Domain\UserIdMother;

final class PurchaseItemCommandMother
{
    public static function create(
        ?ItemId $itemId = null,
        ?UserId $userId = null
    ): PurchaseItemCommand
    {
        return new PurchaseItemCommand(
            $itemId?->value() ?? ItemIdMother::create()->value(),
            $userId?->value() ?? UserIdMother::create()->value()
        );
    }
}
