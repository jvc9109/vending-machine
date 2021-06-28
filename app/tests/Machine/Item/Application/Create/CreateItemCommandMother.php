<?php


namespace VendingMachine\Tests\Machine\Item\Application\Create;


use VendingMachine\Machine\Items\Application\Create\CreateItemCommand;
use VendingMachine\Machine\Items\Domain\ItemId;
use VendingMachine\Machine\Items\Domain\ItemName;
use VendingMachine\Machine\Items\Domain\ItemPrice;
use VendingMachine\Machine\Items\Domain\ItemStock;
use VendingMachine\Tests\Machine\Item\Domain\ItemIdMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemNameMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemPriceMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemStatusMother;

final class CreateItemCommandMother
{
    public static function create(
        ?ItemId $id = null,
        ?ItemName $name = null,
        ?ItemPrice $price = null,
        ?ItemStock $stock = null

    ): CreateItemCommand
    {
        return new CreateItemCommand(
            $id?->value() ?? ItemIdMother::create()->value(),
            $name?->value() ?? ItemNameMother::create()->value(),
            $price?->value() ?? ItemPriceMother::create()->value(),
            $stock?->value() ?? ItemStatusMother::create()->value()
         );
    }

}
