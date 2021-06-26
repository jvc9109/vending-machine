<?php


namespace VendingMachine\Tests\Machine\Item\Domain;


use VendingMachine\Machine\Items\Domain\ItemName;
use VendingMachine\Tests\Shared\Domain\WordMother;

final class ItemNameMother
{
    public static function create(?string $value = null): ItemName
    {
        return new ItemName($value ?? WordMother::create());
    }
}
