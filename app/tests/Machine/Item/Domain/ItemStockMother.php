<?php


namespace VendingMachine\Tests\Machine\Item\Domain;


use VendingMachine\Machine\Items\Domain\ItemStock;
use VendingMachine\Tests\Shared\Domain\MotherCreator;

final class ItemStockMother
{
    public static function create(?int $value = null): ItemStock
    {
        return new ItemStock($value ?? MotherCreator::random()->numberBetween(1,10));
    }
}
