<?php


namespace VendingMachine\Tests\Machine\Item\Domain;


use VendingMachine\Machine\Items\Domain\ItemPrice;
use VendingMachine\Tests\Shared\Domain\MotherCreator;

final class ItemPriceMother
{
    public static function create(?float $value = null): ItemPrice
    {
        return new ItemPrice($value ?? MotherCreator::random()->randomFloat(2));
    }
}
