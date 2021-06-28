<?php


namespace VendingMachine\Tests\Machine\Item\Application\UpdateStock;


use VendingMachine\Machine\Items\Application\UpdateStock\UpdateStockCommand;
use VendingMachine\Machine\Items\Domain\ItemId;
use VendingMachine\Machine\Items\Domain\ItemStock;
use VendingMachine\Tests\Machine\Item\Domain\ItemIdMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemStockMother;

final class UpdateStockCommandMother
{
    public static function create(?ItemId $id = null, ?ItemStock $stock = null): UpdateStockCommand
    {
        return new UpdateStockCommand(
            $id?->value() ?? ItemIdMother::create()->value(),
            $stock?->value() ?? ItemStockMother::create()->value()
        );
    }
}
