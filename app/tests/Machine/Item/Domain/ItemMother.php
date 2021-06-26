<?php


namespace VendingMachine\Tests\Machine\Item\Domain;


use VendingMachine\Machine\Items\Domain\Item;
use VendingMachine\Machine\Items\Domain\ItemId;
use VendingMachine\Machine\Items\Domain\ItemName;
use VendingMachine\Machine\Items\Domain\ItemPrice;
use VendingMachine\Machine\Items\Domain\ItemStatus;
use VendingMachine\Machine\Items\Domain\ItemStock;

final class ItemMother
{
    public static function create(
        ?ItemId $id = null,
        ?ItemName $name = null,
        ?ItemPrice $price = null,
        ?ItemStatus $status = null,
        ?ItemStock $stock = null
    ): Item
    {
        return new Item(
            $id ?? ItemIdMother::create(),
            $name ?? ItemNameMother::create(),
            $price ?? ItemPriceMother::create(),
            $status ?? ItemStatusMother::create(),
            $stock ?? ItemStockMother::create()
        );
    }

}
